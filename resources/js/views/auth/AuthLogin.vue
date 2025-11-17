<template>
  <div class="auth__login">
    <v-form
      :inputs="inputs"
      @submit="login"
    >
      Вход
    </v-form>
    <v-pattern class="v-pattern_transparent_block" style="margin: auto;width: 250px;">
      <p style="font-size: 18px;">Нет аккаунта?</p>
      <v-button 
        @v-button-click="redirect_to_registration" 
        class="btn_animated_float_block" 
        style="align-self: center;"
      >
        Регистрация
      </v-button>
    </v-pattern>
  </div>
</template>

<script>
import auth from '../../auth';

export default {
  name: 'AkkusativAuthLogin',

  data() {
    return {
      inputs: [
        {
          label: 'Логин',
          name: 'login',
          type: 'text',
          char: '@',
        },
        {
          label: 'Пароль',
          name: 'password',
          type: 'password',
        },
        {
          type: 'submit',
          text: 'Войти',
        },
      ],
    };
  },

  mounted() {
    
  },

  methods: {
    redirect_to_registration() {
      this.$router.push(this.$router.resolve({ name: 'auth.registration' }).href);
    },

    login(data) {
      let s = auth.login(data);
      s.then(() => this.$router.push(this.$router.resolve({ name: 'messenger' }).href));
    },
  },
};
</script>

<style>

.v-form {
  margin: auto;
  width: 40%;
}

@media screen and (max-width:850px) {
  .v-form {
    width: 60%;
  }
}

@media screen and (max-width:550px) {
  .v-form {
    width: 80%;
  }
}

@media screen and (max-width:400px) {
  .v-form {
    width: 90%;
  }
}

</style>
