<template>
  <div class="bottom__field">
    <p v-if="field.text">{{ field.text }}</p>
    <div v-if="field.href && field.is_absolute">
      <img v-if="image" :src="image.href" :alt="image.alt"></img>
      <a :href="field.href">
        <p v-if="field.text_link">{{ field.text_link }}</p>
        <p v-else><slot></slot></p>
      </a>
    </div>
    <div v-else-if="field.href">
      <router-link :to="field.href">
        <img v-if="image" :src="image.href" :alt="image.alt"></img>
        <p v-if="field.text_link">{{ field.text_link }}</p>
        <p v-else><slot></slot></p>
      </router-link>
    </div>
    <p v-else-if="field.text_link">{{ field.text_link }}</p>
  </div>
</template>

<script>
export default {
  name: 'VBottomField',

  props: {
    field: [Object],
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