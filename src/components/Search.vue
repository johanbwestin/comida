<template>
  <section class="recipes-section" style>
    <SmallHero title="Sök" />
    <div class="recipes-container">
      <div class="search-container">
        <!-- <label for="search">
          <h3>Sök</h3>
        </label>-->
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
            <div v-for="(res, index) in results" :key="index">
              <router-link :to="'/recept/' + res.id">
                <p>{{res.title.rendered}}</p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <p
        v-if="results.length <= 0 && searchInput || $store.state.results.length <= 0 && results.length <= 0 && !searchInput"
        class="no-results"
      >Vi hittade tyvärr inga träffar på den sökningen.</p>
      <!-- <p
        v-if="$store.state.results.length <= 0 && results.length <= 0 && !searchInput"
        class="no-results"
      >Vi hittade tyvärr inga träffar på den sökningen.</p>-->
      <div v-if="$store.state.results.length > 0 || searchInput" class="title-container">
        <h2>Resultat</h2>
        <span class="line"></span>
      </div>
      <div v-if="$store.state.results.length > 0 && !searchInput" class="card-container">
        <div v-for="(recipe, index) in $store.state.results" :key="index" class="recipes-card">
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
                <h3 v-if="recipe.title">{{recipe.title.rendered}}</h3>
                <p v-if="recipe.meta_box.description">{{recipe.meta_box.description}}</p>
              </div>
            </div>
          </router-link>
        </div>
      </div>
      <div v-if="searchInput || !$store.state.results" class="card-container">
        <div v-for="(recipe, index) in results" :key="index" class="recipes-card">
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
                <h3 v-if="recipe.title">{{recipe.title.rendered}}</h3>
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
  // height: 50vh;
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
        width: 80%;
        margin: {
          top: 4rem;
          bottom: 4rem;
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
          border: none;
        }
      }
      .result-container {
        position: absolute;
        top: 3rem;
        left: 0;
        .result {
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
    .card-container {
      margin: {
        left: auto;
        right: auto;
        bottom: 5rem;
      }
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      .recipes-card {
        width: 33.3%;
        .card {
          .img-container {
            height: 10rem;
            width: 10rem;
            background-color: green;
            img {
              height: 10rem;
              width: 10rem;
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

      // recipes: ,
      // Some Swiper option/callback...
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
    // const params = new URLSearchParams(window.location.search)
    // this.hasUrlParams = params.has("search")
    // if (params.has("search")) {
    //   this.onSubmit(params.get("search"))
    // }
  },
  methods: {
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
            console.log("results:", this.results)
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
            // console.log("results:", this.results)
          })
          .catch(err => {
            console.log(err)
          })
      }
    },
    onSubmit(input) {
      // this.$router.push("/sök").catch(err => console.log(err))
      this.$store.commit("onSearch", input)
    },
    filterResults() {
      this.filteredResults = this.results.filter(res => {
        return res.title.rendered
          .toLowerCase()
          .startsWith(this.searchInput.toLowerCase())
      })
      // this.filteredIngredients = this.results.filter(res => {
      //   res.meta_box.ingredient_list.filter(ing => {
      //     console.log(ing)
      //     ing.name.toLowerCase().startsWith(this.searchInput.toLowerCase())
      //   })
      // })
      // console.log(this.filteredIngredients)
    }
  }
}
</script>