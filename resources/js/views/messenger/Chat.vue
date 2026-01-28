<template>
  <div class="chat">
    <div class="chat__header">
      <span>{{ chat.name }}</span>
    </div>
    <div class="chat__messages">
      <template 
        v-if="chat.messages" 
        v-for="(m, i) in chat.messages"
      >
        <span v-if="m.user_login == login" class="chat__message chat__message_from_me">{{m.message}}<span>{{m.created_at}}</span></span>
        <span v-else="m.user_login == login" class="chat__message chat__message_from_another">{{m.message}}<span>{{m.created_at}}</span></span>
      </template>
      <a id="last_message_link" href="#last_message"></a>
      <div id="last_message"></div>
    </div>
    <div class="chat-sendbox">
      <div class="chat-sendbox__text-field">
        <textarea id="chat-sendbox__message" rows="1" type="text" @input="update_message"></textarea>
        <div class="chat-sendbox__mirror-text" style="white-space:pre-wrap; visibility:hidden; position:absolute; z-index:-1;"></div>
      </div>
      <v-button class="btn_animated_float_block" style="align-self: center;" @click="send_message">Отправить</v-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import auth from '../../auth';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// import { useEcho } from "@laravel/echo-vue";


const options = {
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: 'eu',
}

window.Echo = new Echo({
  ...options,
  client: new Pusher(options.key, options),
});


export default {
  name: 'AkkusativChat',

  props: {
    id: [String],
  },

  data() {
    return {
      chat: {
        name: '',
        messages: [],
      },
      chat_id: null,
      login: auth.get_user(),
      message: '',
    };
  },

  mounted() {
    axios.get('/api/chats/' + this.id)
    .then((response) => {
      this.chat = response.data.data;
      this.chat_id = response.data.data.id;
      
      document.getElementById('last_message_link').click();

      window.Echo.private(`chat.${this.chat_id}`)
      .listen('.chat.message.created', (e) => {
        this.chat.messages.push(e.message);
        document.getElementById('last_message_link').click();
      })

      // useEcho(
      //   `orders.${this.chat_id}`,
      //   '.chat.message.created',
      //   (e) => {
      //       console.log(e.order);
      //   },
      // );
      
    });
    
    document.querySelector('.chat-sendbox__text-field > textarea').addEventListener('input', function() {
      document.querySelector('.chat-sendbox__mirror-text').textContent = this.value;
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });

  },

  methods: {
    update_message(e) {
      this.message = e.target.value;
    },

    send_message() {

      if(this.message.length < 1) return;

      this.chat.messages.push({
        message: this.message,
        user_login: this.login,
      });
      document.getElementById('last_message_link').click();

      axios.post('/api/messages', {
        user_login: auth.get_user(),
        chat_id: this.chat.id,
        message: this.message,
      })
      .then((response) => {
        
      })
      .catch(() => {
        console.log("Error. Data was not synchronized.");
      });

      document.getElementById('chat-sendbox__message').value = '';
      
    }
  },
};
</script>