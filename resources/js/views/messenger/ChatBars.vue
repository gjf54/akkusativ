<template>
  <div class="chat-bars">
    <v-search-bar
      :search_href="'/api/user'"
      @match="render_chat_with_login"
    ></v-search-bar>
    <template
        v-for="(chat, i) in chats"
    >
        <v-chat-bar
            :data="chat"
            @v-chat-bar-click="render_chat"
        >
        </v-chat-bar>
    </template>
  </div>
</template>

<script>
import axios from 'axios';
import MessangerChatsItem from './ChatBar.vue';


export default {
  name: 'VChatBars',


  components: {
    'v-chat-bar': MessangerChatsItem,
  },

  data() {
    return {
      chats: []
    };
  },

  mounted() {
    axios.get('/api/chats')
    .then((r) => {
      r.data.forEach(e => {
        if (e.name == null) e.name = '@' + e.users[0].login,
        this.chats.push(e);
      });
    });
  },

  methods: {
    render_chat(chat) {
      return this.$router.push({name: 'messenger.chat', params: { id: chat.id }});
    },

    render_chat_with_login(login) {
      axios.get('/api/chats/user/'+login)
      .then((response) => {
        if(response.status == 200) {
          return this.render_chat(response.data.data);
        }

        if(response.status == 204) {
          axios.post('/api/chats', {
            login: login,
          })
          .then((response) => {
            console.log(response);
            return this.render_chat(response.data.data);
          })
          .catch((e) => console.log(e));  
        }
      })
      .catch((error) => {
        console.log(error);
      })
    }
  },
};
</script>