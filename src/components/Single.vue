<template>
  <section class="recipe-section" style>
    <SmallHero />
    <div class="content-container">
      <div class="recipe-container">
        <div class="header-container">
          <h2 v-if="title">{{title}}</h2>
          <span class="line"></span>
        </div>
        <div v-if="imageUrl">
          <img :src="imageUrl" :alt="recipe.title" />
        </div>
        <h3 v-if="ingredients.length > 0">Ingredienser</h3>
        <ul>
          <li
            v-for="(ing, index) in ingredients"
            :key="index"
          >{{ing.qty}} {{ing.unit}} {{ing.name}}{{ing.com ? ", " + ing.com : ""}}</li>
        </ul>
        <h3 v-if="instructions.length > 0">Instruktioner</h3>
        <ol>
          <li v-for="(ins, index) in instructions" :key="index">
            <p>{{ins.instruction}}</p>
          </li>
        </ol>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.recipe-section {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-bottom: 3rem;
  align-items: center;
  .content-container {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    min-height: 62vh;
    .recipe-container {
      margin-top: 3rem;
      width: 100%;
      img {
        height: 15rem;
      }
      .header-container {
        align-items: center;
        height: 15%;
        width: 100%;
        h3 {
          padding: 5px;
          color: $bg;
          margin-bottom: 6px;
        }
        .line {
          display: inline-block;
          height: 3px;
          width: 2rem;
          background-color: $thirdary;
        }
      }
    }
  }
}
</style>
<script>
import axios from "axios"
import SmallHero from "./SmallHero.vue"

export default {
  components: {
    SmallHero
  },
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_URL,
      id: this.$route.params.id,
      imageUrl: null,
      title: "",
      file: null,
      ingredients: [],
      instructions: [],
      recipe: {}
    }
  },
  mounted() {
    // Get recipe data
    this.getRecipe()
    // Disable loading spinner
    this.$store.state.loading = false
  },
  methods: {
    // Gets recipe data based on id
    getRecipe() {
      axios({
        url: `${this.apiUrl}wp/v2/recipes/${this.id}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          if(res) {
            this.ingredients = res.data.meta_box.ingredient_list
            this.instructions = res.data.meta_box.instruction_list
            this.title = res.data.title.rendered
            if (res.data.better_featured_image) {
              this.imageUrl = res.data.better_featured_image.source_url
            }
          }
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>