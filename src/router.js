import Vue from 'vue'
import Router from 'vue-router'
import Recipes from './components/Recipes'
import AddRecipe from './components/AddRecipe'
import Login from './components/Login'
import Register from './components/Register'
import Home from './components/Home'
import Single from './components/Single'
import Search from './components/Search'
import Profile from './components/Profile'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      component: Home,
      name: 'home',
      path: '/hem',
      props: true
    },
    {
      component: Recipes,
      name: 'recipe',
      path: '/recept',
      props: true
    },
    {
      component: AddRecipe,
      name: 'addRecipe',
      path: '/recept/nytt',
      props: true
    },
    {
      component: Single,
      name: 'single',
      path: '/recept/:id',
      props: true
    },
    {
      component: Search,
      name: 'search',
      path: '/sök',
      props: true
    },
    {
      component: Login,
      name: 'login',
      path: '/logga-in'
    },
    {
      component: Profile,
      name: 'profile',
      path: '/profil'
    },
    {
      component: Register,
      name: 'register',
      path: '/registrera'
    }
  ]
})