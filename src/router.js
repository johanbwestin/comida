import Vue from 'vue'
import Router from 'vue-router'
import Recipes from './components/Recipes'
import AddRecipe from './components/AddRecipe'
import Login from './components/Login'
import Register from './components/Register'
import Home from './components/Home'
import Single from './components/Single'
import Search from './components/Search'

Vue.use(Router)

export default new Router({
  mode: 'history',
  // base: process.env.BASE_URL,
  routes: [
    {
      component: Home,
      name: 'home',
      path: '/hem',
      props: true
    },
    {
      component: Recipes,
      path: '/recept',
      props: true
    },
    {
      component: AddRecipe,
      path: '/recept/nytt',
      props: true
    },
    {
      component: Single,
      path: '/recept/:id',
      props: true
    },
    {
      component: Search,
      path: '/sök',
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