<template>
    <div class="v-form__group">
        <label :for="id">{{ input.label }}</label>
        <div>
          <span v-if="input.char" :id="'input-' + id + '-char'">
            {{ input.char }}
          </span>
          <input
              class="v-form__input"
              :type="input.type" 
              :name="input.name"
              :id="id"
              :placeholder="input.text"
              autocomplete="off"
              @input="update_input"
          >
        </div>
  </div>
</template>

<script>
export default {
  name: 'VFormInput',

  props: {
    input: [Object],
    modelValue: [String, Number],
  },

  emits: ['update:modelValue'],

  data() {
    return {
      id: 'input-' + Math.ceil(Math.random()*100000),
    };
  },

  mounted() {
    
  },

  methods: {
    update_input(event) {
      this.$emit('update:modelValue', event.target.value);
    }
  },
};
</script>