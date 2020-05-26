<template>
  <section class="add-recipe-section" style>
    <div v-if="resMsg.success || resMsg.error" class="msg-bg">
      <div v-if="resMsg.success" class="msg-container">
        <p>Receptet lades till!</p>
        <div class="btn-container">
          <button @click="resetRecipe">
            <p>Lägg till nytt</p>
          </button>
          <router-link :to="`/recept/${resMsg.id}`">
            <button>
              <p>Till recept</p>
            </button>
          </router-link>
        </div>
      </div>
      <div v-if="resMsg.error" class="msg-container">
        <p>Något gick fel!</p>
        <div class="btn-container">
          <router-link to="/recept/nytt">
            <button>
              <p>Försök igen</p>
            </button>
          </router-link>
        </div>
      </div>
    </div>
    <SmallHero title="Nytt recept" />
    <div class="content-container">
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
            <input
              v-if="uploadRdy"
              type="file"
              name="file"
              @change="handleFileUpload"
              accept="image/*"
            />
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
              <input
                v-model="ingredient.qty"
                class="qty"
                placeholder="Mängd"
                type="number"
                name="qty"
              />
              <input
                v-model="ingredient.unit"
                class="unit"
                placeholder="Enhet"
                type="text"
                name="unit"
              />
              <input
                v-model="ingredient.name"
                class="ing"
                placeholder="Ingrediens"
                type="text"
                name="ingredient"
              />
              <input
                v-model="ingredient.com"
                class="com"
                placeholder="Kommentar"
                type="text"
                name="comment"
              />
            </div>
            <p class="error-text" v-if="ingMsg.error">{{ingMsg.error}}</p>
            <p class="success-text" v-if="ingMsg.success">{{ingMsg.success}}</p>
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
            <input
              v-model="instruction.instruction"
              placeholder="Instruktion"
              type="text"
              name="instruction"
            />
            <p class="error-text" v-if="insMsg.error">{{insMsg.error}}</p>
            <p class="success-text" v-if="insMsg.success">{{insMsg.success}}</p>
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
        <div class="header-container">
          <h2>Förhandsvisning</h2>
          <span class="line"></span>
        </div>
        <h3 v-if="recipe.title">{{recipe.title}}</h3>
        <p v-if="recipe.description">{{recipe.description}}</p>
        <img v-if="imageUrl" :src="imageUrl" :alt="recipe.title" />
        <h3 v-if="recipe.ingredients_list.length > 0">Ingredienser</h3>
        <ul>
          <li v-for="(ing, index) in recipe.ingredients_list" :key="index">
            <div class="flex-container">
              <p
                v-if="!isEditIng || ingIndex !== index"
              >{{ing.qty}} {{ing.unit}} {{ing.name}}{{ing.com ? ", " + ing.com : ""}}</p>
              <div v-if="isEditIng && ingIndex === index" class="ingredient-container">
                <input
                  v-model="edit.qty"
                  class="qty"
                  :placeholder="ing.qty ? ing.qty : 'Mängd'"
                  type="number"
                  name="qty"
                />
                <input
                  v-model="edit.unit"
                  class="unit"
                  :placeholder="ing.unit ? ing.unit : 'Enhet'"
                  type="text"
                  name="unit"
                />
                <input
                  v-model="edit.name"
                  class="ing"
                  :placeholder="ing.name ? ing.name : 'Ingrediens'"
                  type="text"
                  name="ingredient"
                />
                <input
                  v-model="edit.com"
                  class="com"
                  :placeholder="ing.com ? ing.com : 'Kommentar'"
                  type="text"
                  name="comment"
                />
              </div>
              <button
                v-if="!isEditIng || ingIndex !== index"
                @click="editIngredient(index, false)"
                class="edit-btn"
              >
                <p>Redigera</p>
              </button>
              <button
                v-if="isEditIng && ingIndex === index"
                @click="editIngredient(index, edit)"
                class="done-btn"
              >
                <p>Klar</p>
              </button>
              <button
                v-if="isEditIng && ingIndex === index"
                @click="deleteItem(index, 'ingredient')"
                class="remove-btn"
              >
                <p>Ta bort</p>
              </button>
            </div>
          </li>
        </ul>
        <h3 v-if="recipe.instructions_list.length > 0">Instruktioner</h3>
        <ol>
          <li v-for="(ins, index) in recipe.instructions_list" :key="index">
            <div class="flex-container">
              <p v-if="!isEditIns || insIndex !== index">{{ins.instruction}}</p>
              <div v-if="isEditIns && insIndex === index" class="instruction-container">
                <input
                  v-model="editIns.instruction"
                  class="instruction"
                  :placeholder="ins.instruction ? ins.instruction : 'Instruction'"
                  type="text"
                  name="qty"
                />
              </div>
              <button
                v-if="!isEditIns || insIndex !== index"
                @click="editInstruction(index, false)"
                class="edit-btn"
              >
                <p>Redigera</p>
              </button>
              <button
                v-if="isEditIns && insIndex === index"
                @click="editInstruction(index, editIns)"
                class="done-btn"
              >
                <p>Klar</p>
              </button>
              <button
                v-if="isEditIns && insIndex === index"
                @click="deleteItem(index, 'instruction')"
                class="remove-btn"
              >
                <p>Ta bort</p>
              </button>
            </div>
          </li>
        </ol>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.add-recipe-section {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-bottom: 3rem;
  .msg-bg {
    position: fixed;
    top: 0;
    height: 100vh;
    width: 100%;
    z-index: 2;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    .msg-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 20%;
      height: 20%;
      background-color: white;
      p {
        // width: 100%;
      }
      .btn-container {
        margin-top: 1rem;
        button {
          margin: 0.2rem;
          background-color: $primary;
          border: none;
          p {
            padding: 0.5rem;
            color: white;
          }
        }
      }
    }
  }
  .content-container {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    position: relative;
    margin: {
      left: 10%;
      right: 10%;
    }
    @include breakpoint(md) {
      flex-direction: row;
    }
    .preview-container {
      margin-top: 3rem;
      width: 100%;
      @include breakpoint(md) {
        width: 35%;
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
      img {
        height: 10rem;
      }
      ul,
      ol {
        li {
          .flex-container {
            // list-style-type: disc;
            // // list-style: circle;
            // display: list-item;
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            p {
              display: flex;
              align-items: center;
            }
            .ingredient-container,
            .instruction-container {
              display: flex;
              flex-direction: row;
              width: 100%;
              /* Chrome, Safari, Edge, Opera Remove Arrows in number input */
              input::-webkit-outer-spin-button,
              input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
              }
              /* Firefox */
              input[type="number"] {
                -moz-appearance: textfield;
              }
              .qty {
                width: 18%;
              }
              .unit {
                width: 16%;
              }
              .ing {
                width: 34%;
              }
              .com {
                width: 34%;
              }
            }
            .edit-btn {
              background-color: $primary;
              border: none;
              p {
                padding: 0.5rem;
                color: white;
              }
            }
            .done-btn {
              background-color: $primary;
              border: none;
              margin-right: 1px;
              p {
                padding: 0.5rem;
                color: white;
              }
            }
            .remove-btn {
              background-color: $primary;
              border: none;
              width: 20%;
              p {
                padding: 0.5rem;
                color: white;
              }
            }
          }
        }
      }
    }
    .form-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: $bg;
      width: 100%;
      @include breakpoint(md) {
        border-right: 2px dotted $primary;
        width: 50%;
      }
      h2 {
        margin-top: 3rem;
      }
      form {
        display: flex;
        flex-direction: column;
        width: 100%;
        .input-container,
        .button-container {
          position: relative;
          margin: {
            // left: auto;
            // right: auto;
            top: 1.4rem;
          }
          width: 70%;
          .success-text {
            position: absolute;
            color: $thirdary;
          }
          .error-text {
            position: absolute;
            color: red;
          }
          .ingredient-container {
            display: flex;
            flex-direction: row;
            /* Chrome, Safari, Edge, Opera Remove Arrows in number input */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }
            /* Firefox */
            input[type="number"] {
              -moz-appearance: textfield;
            }
            .qty {
              flex: 1;
            }
            .unit {
              flex: 1;
            }
            .ing {
              flex: 3;
            }
            .com {
              flex: 2;
            }
          }
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
      uploadRdy: true,
      resMsg: {
        success: null,
        error: null,
        id: null
      },
      ingMsg: {
        success: null,
        error: null
      },
      insMsg: {
        success: null,
        error: null
      },
      isEditIng: false,
      isEditIns: false,
      ingIndex: null,
      insIndex: null,
      imageUrl: "",
      token: "Bearer " + this.$store.state.token,
      file: null,
      editIns: {
        instruction: null
      },
      ingredient: {
        qty: null,
        unit: null,
        name: null,
        com: null
      },
      edit: {
        qty: null,
        unit: null,
        name: null,
        com: null
      },
      instruction: {
        instruction: null
      },
      recipe: {
        title: null,
        description: null,
        ingredients_list: [],
        instructions_list: []
      }
    }
  },
  mounted() {
    // this.title.charAt(0)
    // console.log(this.title)
    this.$store.state.loading = false
    if (!this.$store.state.token) {
      this.$router.push({ name: "home" }).catch(() => {})
    }
  },
  methods: {
    resetRecipe() {
      this.uploadRdy = false
      this.$nextTick(() => {
        this.uploadRdy = true
      })
      this.resMsg = {
        success: null,
        error: null,
        id: null
      }
      this.ingredient = {
        qty: null,
        unit: null,
        name: null,
        com: null
      }
      this.instruction = {
        instruction: null
      }
      this.recipe = {
        title: null,
        description: null,
        ingredients_list: [],
        instructions_list: []
      }
      this.file = null
      this.imageUrl = null
    },
    editIngredient(index, data) {
      this.isEditIng = !this.isEditIng
      this.ingIndex = index
      if (data) {
        if (!data.qty) {
          data.qty = this.recipe.ingredients_list[index].qty
        }
        if (!data.unit) {
          data.unit = this.recipe.ingredients_list[index].unit
        }
        if (!data.name) {
          data.name = this.recipe.ingredients_list[index].name
        }
        if (!data.com) {
          data.com = this.recipe.ingredients_list[index].com
        }
        this.recipe.ingredients_list[index] = data
        this.edit = {
          qty: null,
          unit: null,
          name: null,
          com: null
        }
      }

      if (this.ingIndex === index && data) {
        this.ingIndex = null
      }
    },
    editInstruction(index, data) {
      this.isEditIns = !this.isEditIns
      this.insIndex = index

      if (data.instruction) {
        this.recipe.instructions_list[index] = data
        this.editIns = null
      }

      if (this.insIndex === index && data) {
        this.insIndex = null
      }
    },
    deleteItem(index, type) {
      if (type === "ingredient") {
        this.recipe.ingredients_list.splice(index, 1)
      }
      if (type === "instruction") {
        this.recipe.instructions_list.splice(index, 1)
      }
    },
    addIngredient(ing) {
      // console.log(ing)
      if (ing.qty && ing.unit && ing.name) {
        this.recipe.ingredients_list.push(ing)
        this.ingredient = {
          qty: null,
          unit: null,
          name: null,
          com: null
        }
        this.ingMsg.success = "Ingrediens lades till!"
        this.ingMsg.error = null
      } else {
        this.ingMsg.error = "Fyll i ovanstående fält!"
        this.ingMsg.success = null
      }
    },
    addInstruction(ins) {
      // console.log(ins)
      if (ins.instruction) {
        this.recipe.instructions_list.push(ins)
        this.instruction = {
          instruction: null
        }
        this.insMsg.success = "Instruktion lades till!"
        this.insMsg.error = null
      } else {
        this.insMsg.error = "Fyll i ovanstående fält!"
        this.insMsg.success = null
      }
    },
    onSubmit() {
      const fd = new FormData()
      // const file = this.file.target.files[0]
      fd.append("file", this.file)
      this.$store.state.loading = true

      // console.log(this.file);
      if (this.file) {
        axios({
          url: `${this.$store.state.apiUrl}wp/v2/media`,
          method: "POST",
          headers: {
            Authorization: this.token
          },
          data: fd
        })
          .then(res => {
            let recipe = {
              title: this.recipe.title,
              featured_media: res.data.id,
              status: "publish",
              meta_box: {
                description: this.recipe.description,
                ingredient_list: this.recipe.ingredients_list,
                instruction_list: this.recipe.instructions_list,
                views: 0
              }
            }
            // console.log(recipe);

            axios({
              url: `${this.$store.state.apiUrl}wp/v2/recipes`,
              method: "POST",
              headers: {
                Authorization: this.token,
                "Content-Type": "application/json"
              },
              data: recipe
            })
              .then(res => {
                console.log(res.data)
                if (res.status === 201) {
                  this.resMsg.success = true
                  this.resMsg.id = res.data.id
                  this.$store.state.loading = false
                }
                this.$store.dispatch("getRecipes")
              })
              .catch(err => {
                console.log(err)
              })
          })
          .catch(err => {
            console.log(err)
          })
      } else {
        let recipe = {
          title: this.recipe.title,
          status: "publish",
          meta_box: {
            description: this.recipe.description,
            ingredient_list: this.recipe.ingredients_list,
            instruction_list: this.recipe.instructions_list,
            views: 0
          }
        }
        axios({
          url: `${this.$store.state.apiUrl}wp/v2/recipes`,
          method: "POST",
          headers: {
            Authorization: this.token,
            "Content-Type": "application/json"
          },
          data: recipe
        })
          .then(res => {
            console.log(res)
            if (res.status === 201) {
              this.resMsg.success = true
              this.resMsg.id = res.data.id
            }
            this.$store.dispatch("getRecipes")
          })
          .catch(err => {
            console.log(err)
          })
      }
    },
    handleFileUpload(e) {
      this.file = e.target.files[0]
      const fileReader = new FileReader()
      fileReader.addEventListener("load", () => {
        this.imageUrl = fileReader.result
      })
      if (this.file) {
        fileReader.readAsDataURL(this.file)
      }
    }
  }
}
</script>