<template>
  <section class="recipes-section" style>
    <Hero title="Recept" />
    <div class="recipes-container">
      <div class="title-container">
        <h2>Recept</h2>
        <span class="line"></span>
      </div>
      <div v-for="(recipe, index) in recipes" :key="index" class="card-container">
        <router-link :to="'/recept/' + recipe.id">
          <div class="card" @click="$store.commit('updateViews', recipe.id)">
            <div class="img-container">
              <img
                v-if="recipe.better_featured_image"
                :src="recipe.better_featured_image.source_url"
                alt
              />
            </div>
            <div class="text-container">
              <h4 v-if="recipe.title">{{recipe.title.rendered}}</h4>
              <p v-if="recipe.meta_box.description">{{recipe.meta_box.description}}</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>
    <button class="pagination" @click="morePosts">
      <p>Visa fler</p>
    </button>
  </section>
</template>
<style lang="scss" scoped>
.recipes-section {
  text-align: start;
  position: relative;
  width: 100%;
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  align-items: center;
  .pagination {
    background-color: $primary;
    border: none;
    p {
      color: white;
      padding: 0.5rem;
    }
  }
  .recipes-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    width: 50%;
    .search-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      input {
        margin: {
          left: auto;
          right: auto;
        }
        height: 2.3rem;
        width: 70%;
      }
    }
    .title-container {
      width: 100%;
      margin: {
        top: 5rem;
      }
      .line {
        display: inline-block;
        height: 3px;
        width: 2rem;
        background-color: $thirdary;
      }
    }
    .card-container {
      margin: {
        top: 1rem;
        bottom: 1rem;
      }
      width: 100%;
      @include breakpoint(md) {
        width: 50%;
      }
      @include breakpoint(lg) {
        width: 33.33333333333333333333333333333333333333333%;
      }
      .card {
        width: 100%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        @include breakpoint(md) {
          width: 90%;
        }
        @include breakpoint(lg) {
          width: 90%;
        }
        .img-container {
          height: 13.5rem;
          width: 100%;
          background-color: lightgray;
          display: flex;
          align-items: center;
          justify-content: center;
          overflow: hidden;
          img {
            height: 100%;
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
}
</style>
<script>
import { mapState } from "vuex"
import Hero from "./Hero.vue"

export default {
  components: {
    Hero
  },
  data() {
    return {
      numOfPosts: 10,
      searchInput: null,
      results: this.$store.state.recipes,
      filteredResults: null,
      filteredIngredients: null
    }
  },
  computed: {
    // State recipes
    ...mapState(["recipes"])
  },
  mounted() {
    // Loads recipes
    // Change last parameter to set num of posts
    this.$store.dispatch("getRecipes", this.numOfPosts)
  },
  methods: {
    // Shows 5 more posts every time the function runs
    morePosts() {
      this.numOfPosts += 5
      this.$store.dispatch("getRecipes", this.numOfPosts)
    },
  }
}
</script>