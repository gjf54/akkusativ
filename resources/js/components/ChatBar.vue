<template>
  <div class="chat-bar" @click="$emit('v-chat-bar-click', data.chat)">
    <div class="chat-bar__container">
      <div class="chat-bar__logo">
        <div>T</div>
      </div>
      <div class="chat-bar__content">
        <span class="chat-bar__title">{{ data.name }}</span>
        <span class="chat-bar__message">{{ data.last_message.message }}</span>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'VChatBar',

  props: {
    data: [Object],
  },

  emits: ['v-chat-bar-click'],

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