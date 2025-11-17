<template>
  <div style="position: relative; width: 90vw; height: 100vh; display: flex; justify-content: center; align-items: center; margin: auto;">
    <div class="messenger" id="messenger">
      <div class="messenger__header" id="messenger__header">
        <img id="messenger__back" :src="images.arrow.href" :alt="images.arrow.alt" @click="back">
        <img id="messenger__logo" :src="images.logo.href" :alt="images.logo.alt">
        <img id="messenger__cross" :src="images.cross.href" :alt="images.cross.alt" @click="logout">
      </div>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import auth from '../../auth';

export default {
  name: 'AkkusativMessenger',

  data() {
    return {
      user: {},
      images: {
        logo: {
          href: '/images/icons/AKK.inline.png',
          alt: 'AKK.',
        },
        arrow: {
          href: '/images/ui/arrow.png',
          alt: 'back',
        },
        cross: {
          href: '/images/ui/cross.png',
          alt: 'logout',
        },
      },
    };
  },

  mounted() {
    let draggable_element = document.getElementById('messenger');
    let drag_trigger = document.getElementById('messenger__header')
    let offsetX, offsetY;

    drag_trigger.addEventListener('mousedown', start_dragging);
    drag_trigger.addEventListener('mouseup', stop_dragging);

    function start_dragging(e) {
        e.preventDefault();
        offsetX = e.clientX - drag_trigger.getBoundingClientRect().left;
        offsetY = e.clientY - drag_trigger.getBoundingClientRect().top;
        draggable_element.classList.add('dragging');
        document.addEventListener('mousemove', drag_element);
    }

    function drag_element(e) {
        e.preventDefault();
        let x = e.clientX - offsetX;
        let y = e.clientY - offsetY;
        draggable_element.style.left = x + 'px';
        draggable_element.style.top = y + 'px';
    }

    function stop_dragging() {
        draggable_element.classList.remove('dragging');
        document.removeEventListener('mousemove', drag_element);
    }
  },

  methods: {
    logout() {
      let s = auth.logout();
      s.then(() => this.$router.push(this.$router.resolve({name:'auth.login'})));
    },

    back() {
      this.$router.go(-1);
    }
  },
};
</script>