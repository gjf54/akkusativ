<template>
  <div style="width:100%;display: flex; justify-content: center; flex-direction: column; align-items: center;">
    <div class="search-bar" @click="() => matches = []">
      <span class="search-bar__char" v-if="char" :id="'input-' + id + '-char'">
          {{ char }}
      </span>
      <input
          type="text"
          name="search"
          class="search-bar__input"
          @input="(e) => text = e.target.value"
      >
      <div class="search-bar__magnifier" @click="search_data">
          <img :src="images.magnifier.href" :alt="images.magnifier.alt">
      </div>
    </div>
    <div class="search-matches">
      <template
        v-for="m in matches"
      >
        <div class="search-matches__match" @click="$emit('match', m.match)">
          <span class="search-matches__text" v-if="char">
            {{ char + m.match }}
          </span> 
          <span class="search-matches__text" v-else>
            {{ m.match }}
          </span>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VSearchBar',

  props: {
    char: {
      type: String,
      default: ''
    },
    search_href: [String],
  },

  data() {
    return {
      id: 'input-' + Math.ceil(Math.random()*100000),
      images: {
        magnifier: {
            href: '/images/ui/magnifier.png',
            alt: 'search',
        }
      },
      matches: [],
      text: '',
    };
  },

  mounted() {

  },

  methods: {


    search_data() {
      if(this.text == '') return;
      axios.get(this.search_href + '/' + this.text)
      .then((response) => {
        response.data.data.forEach(e => {
          this.matches.push({match: e.login})
        });
      })
    }
  },
};
</script>