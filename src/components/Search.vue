<template>
  <section class="recipes-section" style>
    <SmallHero title="Sök" />
    <div class="recipes-container">
      <div class="search-container">
        <div class="input-container">
          <input
            v-model="searchInput"
            @input="getResults"
            class="search-input"
            autocomplete="off"
            type="text"
            name="search"
            placeholder="Sök"
          />
          <button @click="onSubmit(searchInput)" class="search-btn">
            <img src="../assets/media/svg/search-white.svg" alt="search" />
          </button>
          <div class="result-container" v-if="searchInput">
            <router-link
              :to="'/recept/' + res.id"
              v-for="(res, index) in results"
              :key="index"
              class="result-item"
            >
              <p>{{res.title.rendered}}</p>
            </router-link>
          </div>
        </div>
      </div>
      <p
        v-if="results.length <= 0 && searchInput || $store.state.results.length <= 0 && results.length <= 0 && !searchInput"
        class="no-results"
      >Vi hittade tyvärr inga träffar på den sökningen.</p>
      <div v-if="$store.state.results.length > 0 || searchInput" class="title-container">
        <h2>Resultat</h2>
        <span class="line"></span>
      </div>
      <div v-if="$store.state.results.length > 0 && !searchInput" class="result-card-container">
        <div v-for="(recipe, index) in $store.state.results" :key="index" class="card-container">
          <router-link :to="'/recept/' + recipe.id">
            <div class="card" @click="$store.commit('updateViews', recipe.id)">
              <div class="img-container">
                <img
                  v-if="recipe.better_featured_image"
                  :src="recipe.better_featured_image.media_details.sizes.thumbnail.source_url"
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
      <div v-if="searchInput || !$store.state.results" class="result-card-container">
        <div v-for="(recipe, index) in recipes" :key="index" class="card-container">
          <router-link :to="'/recept/' + recipe.id">
            <div class="card" @click="$store.commit('updateViews', recipe.id)">
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
        </div>
      </div>
      <Popular />
      <Latest />
    </div>
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
  .recipes-container {
    width: 50%;
    .search-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      .input-container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin: {
          top: 4rem;
          bottom: 4rem;
        }
        @include breakpoint(md) {
          width: 80%;
        }
        .search-input,
        button {
          height: 2.5rem;
        }
        .search-input {
          width: 100%;
        }
        button {
          background-color: $primary;
          width: 5rem;
          display: flex;
          justify-content: center;
          align-items: center;
          border: none;
        }
      }
      .result-container {
        position: absolute;
        z-index: 4;
        top: 2.5rem;
        left: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-right: 1px solid;
        border-left: 1px solid;
        border-color: lightgray;
        .result-item {
          display: flex;
          background-color: white;
          border-bottom: 1px solid lightgray;
          height: 3rem;
          text-decoration: none;
          p {
            margin: {
              left: 1rem;
              top: auto;
              bottom: auto;
            }
          }
        }
      }
    }
    .title-container {
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
    .result-card-container {
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 5rem;
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
              width: 100%;
            }
          }
          .text-container {
            position: absolute;
            bottom: 1rem;
            width: 87%;
            color: white;
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
}
</style>
<script>
import { mapState } from "vuex"
import SmallHero from "./SmallHero.vue"
import axios from "axios"
import Popular from "./Popular.vue"
import Latest from "./Latest.vue"

export default {
  components: {
    SmallHero,
    Popular,
    Latest
  },
  data() {
    return {
      searchInput: null,
      results: [],
      filteredResults: null,
      filteredIngredients: null,
      hasUrlParams: null
    }
  },
  computed: {
    swiper() {
      return this.swiperName.$swiper
    },
    // State recipes
    ...mapState(["recipes"])
  },
  mounted() {
    // Loads recipes
    // Change last parameter to set num of posts
    this.$store.dispatch("getRecipes")
  },
  methods: {
    // Get search results from wordpress api for autocomplete
    getResults() {
      if (this.searchInput) {
        this.$store.state.results = []
        axios({
          url: `${this.$store.state.apiUrl}wp/v2/recipes?search=${this.searchInput}`,
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        })
          .then(res => {
            this.results = res.data
          })
          .catch(err => {
            console.log(err)
          })
      } else {
        axios({
          url: `${this.$store.state.apiUrl}wp/v2/recipes`,
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        })
          .then(res => {
            this.results = res.data
          })
          .catch(err => {
            console.log(err)
          })
      }
    },
    // Lists all results on submit
    onSubmit(input) {
      this.searchInput = ""
      this.$store.commit("onSearch", input)
    }
  }
}
</script>