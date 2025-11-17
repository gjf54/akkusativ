<template>
  <div class="v-form">
    <div>
      <p class="v-form__title"><slot></slot></p>
      <template v-for="input in inputs">
        <v-form-input 
          v-if="input.type && input.name && input.type != 'submit'"
          :input="input"
          v-model="values[input.name]"
        >
        </v-form-input>
      </template>
      <div class="v-form__group v-form__submitings">
        <template v-for="input in inputs">
            <v-button 
              v-if="input.type == 'submit'" 
              @click="$emit('submit', values)" 
              class="btn_animated_float_block" 
              style="min-width: 80%;"
            >
              {{ input.text }}
            </v-button>
        </template>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'VForm',

  props: {
    inputs: [Array],
  },

  emits: ['submit'],

  data() {
    return {
      values: {},
    }
  },

  mounted() {
    
  },

  methods: {
  
  },
};
</script>
