<template>
  <div v-if="image" class="v-pattern v-pattern_background_image">
    <img
      class="v-pattern_background_image__image" 
      :src="image.href" 
      :alt="image.alt"
    />
    <div class="v-pattern__content v-pattern_background_image__content">
        <slot></slot>
    </div>
  </div>
  <div v-else class="v-pattern">
    <div class="v-pattern__content">
        <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VPattern',

    props: {
        image: [Object],
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