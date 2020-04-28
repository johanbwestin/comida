<template>
  <div id="app">
    <Menu />
    <!-- <Hero /> -->
    <Home />
    <!-- <Register />
    <Login /> -->
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'
import Menu from './components/Menu.vue'
// import Hero from './components/Hero.vue'
// import Login from './components/Login.vue'
// import Register from './components/Register.vue'
import Home from './components/Home.vue'

export default {
  name: 'App',
  components: {
    Menu,
    // Hero,
    Home,
    // Login,
    // Register,
    HelloWorld,
  }
}
</script>

<style lang="scss">

#app {
  // -webkit-font-smoothing: antialiased;
  // -moz-osx-font-smoothing: grayscale;
  // text-align: center;
}
</style>
