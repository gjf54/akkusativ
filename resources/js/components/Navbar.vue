<template>
  <div class="v-navbar">
    <div id="v-navbar__image">
      <img @click="redirect_to_home" :src="images.icon.href" :alt="images.icon.alt">
    </div>
    <div class="v-navbar__items">
      <div 
        class="v-navbar__item" 
        v-for="(route, index) in routes" 
        :key="index"
      >
        <v-navbar-link :href="route.href">{{ route.name }}</v-navbar-link>
      </div>
    </div>
  </div>
</template>

<script>
import auth from '../auth';

export default {
  name: 'VNavbar',

  data() {
    return {
      routes: [
        {
          href: this.$router.resolve({ name: 'home' }).href, 
          name: 'Главная'
        },
        {
          href: this.$router.resolve({ name: 'about' }).href, 
          name: 'О проекте'
        },
      ],
      images: {
        icon: {
          href: '/images/icons/AKK.inline.png',
          alt: 'AKK.',
        },
      },
    };
  },

  mounted() {
    auth.check_auth_status()
    .then(() => { 
      this.routes.push({
          href: this.$router.resolve({ name: 'messenger' }).href, 
          name: 'Мессенджер'
      });
    })
    .catch(() => {
      this.routes.push({
        href: this.$router.resolve({ name: 'auth.login' }).href, 
        name: 'Войти'
      });
    });
  },

  methods: {
    redirect_to_home() {
      this.$router.push(this.$router.resolve({ name: 'home' }).href);
    }
  },
};
</script>