<template>
  <div class="v-navbar__link">
    <router-link :to="href">
      <span><slot></slot></span>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'VNavbarLink',

  props: {
    href: [String],
  },

  data() {
    return {
      
    };
  },

  mounted() {
    
  },

  methods: {
    
  },
};
</script>
