import { toInteger } from "lodash";


const auth = {

    AUTH_STATUS_NAME: 'auth',
    AUTH_LOGIN_URL: '/api/auth/login',
    AUTH_REGISTER_URL: '/api/auth/register',
    AUTH_LOGOUT_URL: '/api/auth/logout',
    AUTH_USER_URL: '/api/user',


    register(credentials) {
        return new Promise ((resolve, reject) => {
            axios.post(this.AUTH_REGISTER_URL, credentials)
            .then((response) => {
                auth.set_auth_status(response.data.login, response.data.ttl);
                resolve();
            })
            .catch((error) => {
                console.log(error);
                reject();
            });
        });
    },


    login(credentials) {
        return new Promise ((resolve, reject) => {
            axios.post(this.AUTH_LOGIN_URL, credentials)
            .then((response) => {
                auth.set_auth_status(response.data.login, response.data.ttl);
                resolve();
            })
            .catch((error) => {
                console.log(error);
                reject();
            });
        });
    },


    logout() {
        return new Promise((resolve, reject) => { 
            axios.post(this.AUTH_LOGOUT_URL)
            .then((response) => {
                this.unset_auth_status();
                resolve();
            })
            .catch((error) => {
                if(error.response.status == 401) {
                    this.unset_auth_status();
                    resolve();
                }
                console.log(error);
                reject();
            });
        });
    },


    set_auth_status(login, ttl) {

        // ttl in minutes
        
        let now = new Date();
        
        localStorage.setItem(this.AUTH_STATUS_NAME, JSON.stringify({
            login: login,
            created_at: now.getTime(),
            expires_in: toInteger(ttl) * 60,
        }));
    },


    check_auth_status() {
        return new Promise ((resolve, reject) => {
            let f = JSON.parse(localStorage.getItem(this.AUTH_STATUS_NAME));

            if(f) {
                let now = new Date(); 
                if(f.expires_in + f.created_at > now.getTime()) return resolve();    
            }

            return reject(false);
        });
    },


    unset_auth_status() {
        localStorage.removeItem(this.AUTH_STATUS_NAME);
    },


    request_auth_status() {
        return new Promise ((resolve, reject) => {
            axios.get(this.AUTH_USER_URL)
            .then(() => {
                 let f = JSON.parse(localStorage.getItem(this.AUTH_STATUS_NAME));

                if(!f) {
                    let now = new Date(); 
                    if(f.expires_in + f.created_at > now.getTime()) return resolve();    
                }

                resolve();
            })
            .catch(() => {this.unset_auth_status(); reject(false);});
        });
    },


    get_user() {
        return JSON.parse(localStorage.getItem(this.AUTH_STATUS_NAME)).login;
    }
};

export default auth;