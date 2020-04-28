<template>
  <section class="home-section" style>
    <!-- <Login v-if="!$store.state.isLoggedIn" /> -->
    <Hero />
    <routerView />
    <div class="popular-container">
      <div class="text-container">
        <h2>Populärt</h2>
        <span class="line"></span>
      </div>
      <swiper ref="mySwiper" :options="swiperOptions">
        <swiper-slide v-for="project in test" :key="project" class="project">
          <div class="card-container">
            <div class="card">phej</div>
          </div>
        </swiper-slide>
      </swiper>
      <div id="swiper-pagination" class="swiper-pagination" slot="pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <div class="latest-container">
      <div class="text-container">
        <h2>Senaste</h2>
        <span class="line"></span>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
  // SWIPER
  #swiper-pagination ::v-deep {
    width: 100%;
    z-index: 1;
    @include breakpoint(xl) {
      bottom: 2rem;
    }
    .swiper-pagination-bullet {
      height: 0.8rem;
      width: 0.8rem;
      margin: 1px;
      opacity: 0.4;
      background-color: $primary;
    }
    .swiper-pagination-bullet-active {
      opacity: 1;
      background-color: $primary;
    }
  }
  .swiper-button-next,.swiper-button-prev {
    color: $primary;
      z-index: 1;
  }

  .home-section {
    // height: 50vh;
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    position: relative;
    z-index: 1;
    .popular-container,
    .latest-container {
      text-align: start;
      width: 50%;
      h2,
      .line {
      }
      .line {
        display: inline-block;
        height: 3px;
        width: 2rem;
        background-color: $thirdary;
      }
    }
    .popular-container {
      position: relative;
      height: 50vh;
    }
  }
</style>
<script>
  import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
  // import Login from './Login.vue'
  import Hero from './Hero.vue'


  import 'swiper/css/swiper.css'

  export default {
    /* eslint-disable sort-keys */
    components: {
      Swiper,
      SwiperSlide,
      // Login,
      Hero
    },
    directives: {
      swiper: directive
    },
    computed: {
      swiper() {
        return this.$refs.mySwiper.$swiper
      }
    },
    data() {
      return {
        test: [0, 1, 2, 3, 4, 5],
        isLoggedIn: false,
        swiperOptions: {
          slidesPerView: 'auto',
          pagination: {
            el: '.swiper-pagination',
            type: "bullets"
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          // Some Swiper option/callback...
        },
      }
    },
    mounted() {
      this.$store.commit('checkStatus')
    },
    methods: {
    },
  }
</script>