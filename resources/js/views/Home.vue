<template>
  <div class="page">
    <v-navbar></v-navbar>
    <div class="page__content">
      <v-pattern :image="images.background" style="margin:auto;">
        <img :src="images.icon.href" :alt="images.icon.alt">
        <p></p>
        <p></p>
        <p style="font-size: 30px; font-weight: bold; color: #555; font-style: italic;">Ваш новый проводник в мир безграниченного общения</p>
      </v-pattern>
    </div>
    <v-bottom></v-bottom>
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';

export default {
  name: 'AkkusativHome',

  data() {
    return {
      images: {
        icon: {
          href: '/images/icons/Akkusativ.inline.empty.png',
          alt: 'Akkusativ',
        },
        background: {
          href: '/images/views/home/background.png',
          alt: 'Background graphics',
        },
      },
    };
  },

  mounted() {
    
  },

  methods: {
    
  },
};
</script>