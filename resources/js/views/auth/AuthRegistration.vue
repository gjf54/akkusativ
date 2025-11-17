<template>
  <div>
    <v-form
      :inputs="inputs"
      @submit="register"
    >
      Регистрация
    </v-form>
    <v-pattern class="v-pattern_transparent_block" style="margin: auto;width: 250px;">
      <p style="font-size: 18px;">Уже есть аккаунт?</p>
      <v-button @v-button-click="redirect_to_login" class="btn_animated_float_block" style="align-self: center;">Вход</v-button>
    </v-pattern>
  </div>
</template>

<script>
import auth from '../../auth';


export default {
  name: 'AkkusativAuthRegistration',

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
          label: 'Повтор пароля',
          name: 'password_repeat',
          type: 'password',
        },
        {
          type: 'submit',
          text: 'Зарегестрироваться'
        },
      ],
    };
  },

  mounted() {
    
  },

  methods: {
    redirect_to_login() {
      this.$router.push(this.$router.resolve({ name: 'auth.login' }).href);
    },

    register(data) {
      let s = auth.register(data);
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