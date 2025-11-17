<template>
  <div class="bottom">
    <div class="bottom__logo">
      <img :src="images.icon.href" :alt="images.icon.alt">
    </div>
    <div class="bottom__fields"
      v-for="i in fields.length"
    >
      <v-bottom-field
        v-for="field in fields[i-1]"
        :field="field"
      >
      </v-bottom-field>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VBottom',

  data() {
    return {
      images: {
        icon: {
          href: '/images/icons/AKK.block.png',
          alt: 'AKK.'
        }
      },

      fields: [
        [
          {
            text: 'Контактная почта:',
            text_link: 'support@akkusativ.ru',
            href: 'mailto://trrt1004@gmail.com',
            is_absolute: true,
          },
          
        ],
        [
          {
            text: 'Создано при поддержке ',
            text_link: 'MW Inc.',
            href: 'mailto://trrt1004@gmail.com',
            is_absolute: false,
          },
        ]
      ],
    };
  },

  mounted() {
    
  },

  methods: {

  },
};
</script>