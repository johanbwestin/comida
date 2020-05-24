<template>
  <section class="recipe-section" style>
    <SmallHero />
    <div class="content-container">
      <div class="recipe-container">
        <div class="header-container">
          <h2 v-if="title">{{title}}</h2>
          <span class="line"></span>
        </div>
        <!-- <h3 v-if="recipe.title">{{recipe.title}}</h3> -->
        <!-- <p v-if="recipe.description">{{recipe.description}}</p> -->
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
  // height: 95vh;
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
      img {
        // height: 10rem;
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
      // token: "Bearer " + this.$store.state.token,
      file: null,
      ingredients: [],
      instructions: [],
      recipe: {}
    }
  },
  mounted() {
    console.log()
    this.getRecipe()
  },
  methods: {
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
            // console.log(res.data.better_featured_image.media_details.sizes.large.source_url)
            this.ingredients = res.data.meta_box.ingredient_list
            this.instructions = res.data.meta_box.instruction_list
            this.title = res.data.title.rendered
            if (res.data.better_featured_image) {
              this.imageUrl = res.data.better_featured_image.media_details.sizes.medium.source_url
            }
            console.log('from single ', this.title)
          }
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>