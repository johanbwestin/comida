<template>
  <section class="hero-section" style>
    <div class="top" id="top"></div>
    <div class="hero-text-container">
      <div class="search-container">
        <label for="search">
          <span class="line"></span>
          <h1 class="logo" id="title">{{title}}</h1>
          <span class="line"></span>
        </label>
        <div class="input-container">
          <form autocomplete="off">
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
          </form>
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
    </div>
  </section>
</template>
<style lang="scss" scoped>
.hero-section {
  position: relative;
  height: 60vh;
  width: 100%;
  background-image: url("../assets/media/png/bg-img-full.jpg");
  background-size: cover;
  background-position-y: 80%;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
  .top {
    position: absolute;
    top: 0;
  }
  .hero-text-container {
    width: 100%;
    .search-container {
      display: flex;
      flex: 1;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      label {
        color: $primary;
        display: flex;
        flex: 1;
        flex-direction: row;
        align-items: center;
        margin: {
          bottom: 0.5rem;
          top: 2rem;
        }
        .logo {
          padding: 5px;
          color: $bg;
          margin-bottom: 10px;
          color: $primary;
        }
        h1 {
          padding: 5px;
          color: $primary;
          margin-bottom: 10px;
          text-transform: capitalize;
        }
        .line {
          display: inline-block;
          width: 20px;
          height: 4px;
          background: $primary;
        }
      }
      .input-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        width: 70%;
        @include breakpoint(sm) {
          width: 30%;
        }
        form {
          display: flex;
          align-items: center;
          justify-content: center;
          width: 100%;
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
    }
  }
}
</style>
<script>
import axios from "axios"

export default {
  props: {
    title: String
  },
  data() {
    return {
      searchInput: null,
      results: []
    }
  },
  mounted() {},
  methods: {
    // Get search resaults from wordpress api for autocomplete
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
    // Pushes user to search page if user submits with search input as argument
    onSubmit(input) {
      this.$router.push("/sök")
      this.$store.commit("onSearch", input)
    }
  }
}
</script>