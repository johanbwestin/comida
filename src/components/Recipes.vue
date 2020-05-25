<template>
  <section class="recipes-section" style>
    <Hero title="Recept" />
    <div class="recipes-container">
      <div class="title-container">
        <h2>Recept</h2>
        <span class="line"></span>
        <hollow-dots-spinner
          v-if="$store.state.loading"
          :animation-duration="1200"
          :circles-num="3"
          :circle-size="15"
          color="#EC4E20"
        />
      </div>
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
      <button class="pagination" @click="addPosts"><p>Visa fler</p></button>
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
    // align-items: center;
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
      width: 33.33333333333333333333333333333333333333333%;
      margin: {
        top: 1rem;
        bottom: 1rem;
      }
      .card {
        width: 90%;
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
            // height: 100%;
            width: 100%;
          }
        }
        .text-container {
          position: absolute;
          bottom: 1rem;
          // left: 1rem;
          width: 87%;
          // color: $primary;
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
import axios from "axios"

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
    swiper() {
      return this.swiperName.$swiper
    },
    // State recipes
    ...mapState(["recipes"])
  },
  mounted() {
    // Loads recipes
    // Change last parameter to set num of posts
    this.$store.dispatch("getRecipes", this.numOfPosts)
  },
  methods: {
    addPosts() {
      this.numOfPosts += 5 
      this.$store.dispatch("getRecipes", this.numOfPosts)

    },
    onSubmit(input) {
      this.$router.push("/sök")
      this.$store.commit("onSearch", input)
    },
    getResults() {
      if (this.searchInput) {
        console.log(this.$store.state.recipes)

        axios({
          url: `${this.$store.state.apiUrl}wp/v2/recipes?search=${this.searchInput}`,
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        })
          .then(res => {
            console.log(res.data[0].title)
            // this.results = res.data
          })
          .catch(err => {
            console.log(err)
          })
      }
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