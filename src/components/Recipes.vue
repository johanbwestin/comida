<template>
  <section class="recipe-section" style>
    <div class="form-container">
      <div class="header-container">
        <h2>Lägg till recept</h2>
        <span class="line"></span>
      </div>
      <form action>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Rubrik</h4>
          </label>
          <input v-model="recipe.title" placeholder="Rubrik" type="text" name="title" />
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Lägg till bild</h4>
          </label>
          <input type="file" name="file" @change="handleFileUpload" />
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Beskrivning</h4>
          </label>
          <input
            v-model="recipe.description"
            placeholder="Instruktion"
            type="text"
            name="description"
          />
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Ingredienser</h4>
          </label>
          <div class="ingredient-container">
            <input v-model="ingredient.qty" placeholder="Mängd" type="number" name="qty" />
            <input v-model="ingredient.unit" placeholder="Enhet" type="text" name="unit" />
            <input v-model="ingredient.name" placeholder="Ingrediens" type="text" name="ingredient" />
            <input v-model="ingredient.com" placeholder="Kommentar" type="text" name="comment" />
          </div>
          <div class="button-container">
            <button class="add-btn" @click.prevent="addIngredient(ingredient)">
              <p>Lägg till</p>
            </button>
          </div>
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Instruktioner</h4>
          </label>
          <input v-model="instruction" placeholder="Instruktion" type="text" name="instruction" />
          <div class="button-container">
            <button class="add-btn" @click.prevent="addInstruction(instruction)">
              <p>Lägg till</p>
            </button>
          </div>
        </div>
        <div class="button-container">
          <button class="back-btn">
            <p>Tillbaka</p>
          </button>
          <button class="submit-btn" @click.prevent="onSubmit">
            <p>Skicka</p>
          </button>
        </div>
      </form>
    </div>
    <div class="preview-container">
      <h2>{{recipe.title}}</h2>
      <p>{{recipe.description}}</p>
      <h3 v-if="recipe.title">Ingredienser</h3>
      <ul>
        <li
          v-for="(ing, index) in recipe.ingredients"
          :key="index"
        >{{ing.qty}} {{ing.unit}} {{ing.name}}{{ing.com ? ", " + ing.com : ""}}</li>
      </ul>
      <h3 v-if="recipe.title">Instruktioner</h3>
      <ol>
        <li v-for="(ins, index) in recipe.instructions" :key="index">
          <p>{{ins}}</p>
        </li>
      </ol>
    </div>
  </section>
</template>
<style lang="scss" scoped>
  .recipe-section {
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    .preview-container {
      flex: 1;
    }
    .form-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 45vh;
      width: 50%;
      background-color: $bg;
      form {
        display: flex;
        flex-direction: column;
        width: 100%;
        .input-container,
        .button-container {
          margin: {
            // left: auto;
            // right: auto;
            top: 1rem;
          }
          width: 70%;
          input {
            height: 2.3rem;
            width: 100%;
          }
          .add-btn,
          .back-btn,
          .submit-btn {
            border: none;
            background-color: $primary;
            p {
              font-size: 0.9rem;
              color: $bg;
              padding: {
                top: 5px;
                bottom: 5px;
                left: 8px;
                right: 8px;
              }
            }
          }
          .back-btn {
            margin-right: 0.5rem;
          }
        }
      }
      .header-container {
        // justify-content: center;
        align-items: center;
        // display: flex;
        height: 15%;
        width: 100%;
        // background-color: $primary;
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
</style>
<script>
  export default {
    data() {
      return {
        // test: process.env.TITLE,
        file: null,
        ingredient: {
          qty: null,
          unit: null,
          name: null,
          com: null,
        },
        instruction: null,
        recipe: {
          title: null,
          description: null,
          ingredients: [],
          instructions: [],
        }
      }
    },
    mounted() {
      },
    methods: {
      addIngredient(ing) {
      // console.log(process.env.VUE_APP_API_URL)
        this.recipe.ingredients.push(ing)
        this.ingredient = {
          qty: null,
          unit: null,
          name: null,
          com: null,
        }
      },
      addInstruction(ins) {
        console.log(ins)
        this.recipe.instructions.push(ins)
        this.instruction = null
      },
      onSubmit() {
        this.$store.commit("login", this.user)
      },
      handleFileUpload(e) {
        this.file = e.target.files[0];
      }
    },
  }
</script>