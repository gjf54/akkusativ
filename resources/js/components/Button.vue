<template>
  <div class="btn" @click="$emit('VButtonClick')">
    <img v-if="image" :src="image.href" :alt="image.alt">
    <span><slot></slot></span>
  </div>
</template>

<script>
export default {
  name: 'VButton',

  props: {
    image: {
      type: Object,
      default: null,
    }
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