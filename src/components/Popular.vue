<template>
  <section class="popular-section" style>
    <div class="text-container">
      <h2>Populärt</h2>
      <span class="line"></span>
    </div>
    <swiper :ref="swiperName" :options="swiperOptions">
      <swiper-slide v-for="(recipe, index) in popularRecipes" :key="index" class="popular-card">
        <router-link :to="'/recept/' + recipe.id">
          <div class="card-container" @click="$store.commit('updateViews', recipe.id)">
            <div class="img-container">
              <img
                v-if="recipe.better_featured_image"
                :src="recipe.better_featured_image.media_details.sizes.medium.source_url"
                alt
              />
            </div>
            <div class="text-container">
              <h4 v-if="recipe.title">{{recipe.title.rendered}}</h4>
              <p v-if="recipe.meta_box.description">{{recipe.meta_box.description}}</p>
            </div>
          </div>
        </router-link>
      </swiper-slide>
    </swiper>
    <div id="swiper-one-pagination" class="swiper-pagination" slot="pagination"></div>
    <div id="swiper-one-prev" class="swiper-button-prev"></div>
    <div id="swiper-one-next" class="swiper-button-next"></div>
  </section>
</template>
<style lang="scss" scoped>
.popular-section {
  text-align: start;
  position: relative;
  width: 100%;
  margin-bottom: 5rem;
  // SWIPER
  #swiper-one-pagination ::v-deep {
    width: 100%;
    z-index: 1;
    bottom: -2rem;
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
  #swiper-one-next,
  #swiper-one-prev {
    color: $primary;
    z-index: 1;
  }
  .swiper-button-prev {
    left: -50px;
  }
  .swiper-button-next {
    right: -50px;
  }
  .line {
    display: inline-block;
    height: 3px;
    width: 2rem;
    background-color: $thirdary;
  }
  .popular-card {
    width: 100%;
    @include breakpoint(md) {
      width: 50%;
    }
    @include breakpoint(lg) {
      width: 33.33333333333333333333333333333333333333333%;
    }
    .card-container {
      width: 100%;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      .img-container {
        height: 13.5rem;
        width: 100%;
        background-color: lightgray;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        img {
          width: 100%;
        }
      }
      .text-container {
        position: absolute;
        bottom: 1rem;
        width: 87%;
        margin: {
          left: auto;
          right: auto;
        }
        h4,
        p {
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 1; /* number of lines to show */
          -webkit-box-orient: vertical;
          color: white;
        }
      }
    }
  }
}
</style>
<script>
import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper"
import "swiper/css/swiper.css"
import { mapState } from "vuex"

export default {
  components: {
    Swiper,
    SwiperSlide
  },
  directives: {
    swiper: directive
  },
  data() {
    return {
      // Swiper options
      swiperName: "mySwiper2",
      swiperOptions: {
        slidesPerView: "auto",
        pagination: {
          el: "#swiper-one-pagination",
          type: "bullets"
        },
        navigation: {
          nextEl: "#swiper-one-next",
          prevEl: "#swiper-one-prev"
        },
        spaceBetween: 16
      }
    }
  },
  computed: {
    swiper() {
      return this.swiperName.$swiper
    },
    // State recipes
    ...mapState(["popularRecipes"])
  },
  mounted() {
    // Loads recipes
    // Change last parameter to set num of posts
    this.$store.dispatch("getPopularRecipes", 6)
  },
  methods: {}
}
</script>