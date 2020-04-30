import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
// import Home from './components/Home'
import Recipes from './components/Recipes'
import Login from './components/Login'
import Register from './components/Register'

Vue.use(VueResource)
Vue.use(Vuex)
Vue.use(VueRouter)

Vue.http.options.root = process.env.VUE_APP_API_URL

Vue.config.productionTip = false

const mutations = {
  userLogin(state, user) {
    console.log()
    fetch(`${state.apiUrl}jwt-auth/v1/token`, {
      body: JSON.stringify(user),
      headers: {
        'Content-Type': 'application/json'
      },
      method: 'POST'
    }).then(response => response.json())
      .then(response => {
        // console.log(response.status)
        // console.log(response)
        if (response.data) {
          state.message = response.message
          console.log(state.message)
        }
        if (response.token) {
          state.token = response.token
          localStorage.setItem('token', state.token)
        }

      }).then(() => { store.commit('checkStatus') })
      .catch(error => {
        console.log(error)
      })
  },
  registerUser(state, userData) {
    console.log(userData)
    if (userData.terms) {
      fetch(`${state.apiUrl}wp/v2/users/register`, {
        body: JSON.stringify(userData.user),
        headers: {
          'Content-Type': 'application/json'
        },
        method: 'POST'
      }).then(response => response.json())
        .then(response => {
          // console.log(response)
          state.message = response.message
          // console.log(state.message)
        }).then(() => router.push('home')).catch(() => { })
        .catch(error => {
          console.log(error)
        })
    }
  },
  checkStatus(state) {
    if (state.token) {
      state.isLoggedIn = true
      router.push('home').catch(() => { })
    } else {
      state.isLoggedIn = false
      router.push('logga-in').catch(() => { })
    }
  },
  // strippedContent(state, content) {
  //   console.log(content)
  //   let regex = /(<([^>]+)>)/ig;
  //   return console.log(content.replace(regex, ""));
  // }
}

const state = {
  token: localStorage.getItem('token') || null,
  isLoggedIn: false,
  message: null,
  apiUrl: process.env.VUE_APP_API_URL
}

const store = new Vuex.Store({
  mutations,
  state
})

const router = new VueRouter({
  routes: [
    {
      // component: Home,
      path: '/',
      props: true
    },
    {
      component: Recipes,
      path: '/recept',
      props: true
    },
    {
      component: Login,
      path: '/logga-in'
    },
    {
      component: Register,
      path: '/registrera'
    }
  ]
})

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
