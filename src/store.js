import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios"
import router from './router'

Vue.use(Vuex, axios)

export default new Vuex.Store({
  actions: {
    getRecipes({ commit }, numOfPosts) {
      axios({
        url: `${this.state.apiUrl}wp/v2/recipes/?per_page=${numOfPosts}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          console.log(res)
          let recipes
          if(res.status === 200) {
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
    getPopularRecipes({ commit }, numOfPosts) {
      axios({
        url: `${this.state.apiUrl}wp/v2/recipes/?per_page=100`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          console.log(res)
          const recipes = res.data
          commit('setPopularRecipes', {recipes, numOfPosts})
        })
        .catch(err => {
          console.log(err)
        })
    }
  },
  mutations: {
    onLoad(state, isLoading) {
      state.loading = isLoading
    },
    onSearch(state, params) {
      console.log(params)
      axios({
        url: `${state.apiUrl}wp/v2/recipes?search=${params}`,
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
    updateViews(state, id) {
      console.log('from updateViews')
      axios({
        url: `${state.apiUrl}base/views/${id}`,
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    setPopularRecipes(state, {recipes, numOfPosts}) {
      // Sorting out the top 5 most viewed recipes
      state.popularRecipes = recipes.sort((a, b) => Number(b.meta_box.views) - Number(a.meta_box.views)).slice(0,numOfPosts)
    },
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
            console.log(res.statusText)
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
    registerUser(state, userData) {
      console.log(userData.user)
      if (userData.terms) {
        axios(`${state.apiUrl}wp/v2/users/register`, {
          data: JSON.stringify(userData.user),
          headers: {
            'Content-Type': 'application/json'
          },
          method: 'POST'
        })
          .then(res => {
            console.log(res)
          }).then(() => router.push({ name: 'home' })).catch(() => {})
          .catch(err => {
            console.log(err)
          })
      }
    },
    checkStatus(state) {
      if (state.token) {
        state.isLoggedIn = true
        router.push({ name: 'home' }).catch(() => { })
      } else {
        state.isLoggedIn = false
      }
    },
    setRecipes(state, recipes) {
      state.recipes = recipes
    },
    strippedContent(state, content) {
      console.log(content)
      let regex = /(<([^>]+)>)/ig
      return console.log(content.replace(regex, ""))
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