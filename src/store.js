import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios"
import router from './router'

Vue.use(Vuex, axios)

export default new Vuex.Store({
  actions: {
    // Gets numOfPosts amount of posts from wp api
    getRecipes({ commit }, numOfPosts) {
      if (!numOfPosts) {
        numOfPosts = 10
      }
      axios({
        url: `${this.state.apiUrl}wp/v2/recipes/?per_page=${numOfPosts}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          let recipes
          if (res.status === 200) {
            commit('onLoad', false)
          } else {
            commit('onLoad', true)
          }
          recipes = res.data
          commit("setRecipes", recipes)
        })
        .catch(err => {
          console.log(err)
        })
    },
    // Get all posts for setPopularRecipes() to set the most viewed posts
    getPopularRecipes({ commit }, numOfPosts) {
      axios({
        url: `${this.state.apiUrl}wp/v2/recipes/?per_page=100`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          const recipes = res.data
          commit('setPopularRecipes', { recipes, numOfPosts })
        })
        .catch(err => {
          console.log(err)
        })
    }
  },
  mutations: {
    // Handles loading spinner
    onLoad(state, isLoading) {
      state.loading = isLoading
    },
    // Fetches the post from wp api based on searchParams
    onSearch(state, searchParams) {
      axios({
        url: `${state.apiUrl}wp/v2/recipes?search=${searchParams}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          state.results = res.data
        })
        .catch(err => {
          console.log(err)
        })
    },
    // Update views on a recipe when recipe is viewed
    updateViews(state, id) {
      axios({
        url: `${state.apiUrl}base/views/${id}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(() => {
        })
        .catch(err => {
          console.log(err)
        })
    },
    // Sorting out the popular posts based on viewes
    setPopularRecipes(state, { recipes, numOfPosts }) {
      // Sorting out the top 5 most viewed recipes
      state.popularRecipes = recipes.sort((a, b) => Number(b.meta_box.views) - Number(a.meta_box.views)).slice(0, numOfPosts)
    },
    // Handles login
    userLogin(state, user) {
      axios(`${state.apiUrl}jwt-auth/v1/token`, {
        data: JSON.stringify(user),
        headers: {
          'Content-Type': 'application/json'
        },
        method: 'POST'
      })
        .then(res => {
          if (res.request.status === 200) {
            state.message = null
          }
          if (res.data.status === 403) {
            state.message = "Inloggningen misslyckades. Kontrollera dina uppgifter och försök igen."
          }
          if (res.data.token) {
            state.token = res.data.token
            localStorage.setItem('token', state.token)
          }
        }).then(() => { this.commit('checkStatus') })
        .catch(err => {
          console.log(err)
        })
    },
    // Handles user registration. this function is not in use at the moment.
    // Registration is handled by a custom wordpress page
    registerUser(state, userData) {
      if (userData.terms) {
        axios(`${state.apiUrl}wp/v2/users/register`, {
          data: JSON.stringify(userData.user),
          headers: {
            'Content-Type': 'application/json'
          },
          method: 'POST'
        })
          .then(() => {
          }).then(() => router.push({ name: 'home' })).catch(() => { })
          .catch(err => {
            console.log(err)
          })
      }
    },
    // Checks the status of the user
    checkStatus(state) {
      if (state.token) {
        state.isLoggedIn = true
        router.push({ name: 'home' }).catch(() => { })
      } else {
        state.isLoggedIn = false
      }
    },
    // Stores fetched recipes in state object
    setRecipes(state, recipes) {
      state.recipes = recipes
    },
    // Clears a string of unwanted characters
    strippedContent(state, content) {
      let regex = /(<([^>]+)>)/ig
      return content.replace(regex, "")
    }
  },

  state: {
    loading: true,
    results: [],
    popularRecipes: [],
    recipes: [],
    token: (localStorage.getItem('token') || null),
    isLoggedIn: false,
    message: null,
    apiUrl: process.env.VUE_APP_API_URL
  },
})