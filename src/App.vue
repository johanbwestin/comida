<template>
  <div id="app">
    <Menu />
    <!-- <Hero /> -->
    <!-- <Home /> -->
    <!-- <Register />
    <HelloWorld msg="Welcome to Your Vue.js App"/> -->
    <routerView />
    <Foot /> 
  </div>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import Menu from './components/Menu.vue'
import Foot from './components/Foot.vue'

export default {
  name: 'App',
  components: {
    Menu,
    Foot,
    // HelloWorld,
  },
  mounted() {
    // console.log(this.$route.path)
    if(this.$route.path === "/") {
      this.$router.push('/hem').catch(() => { })
    }
  }
}
</script>

<style lang="scss">
#app {
  scroll-behavior: smooth;
  // -webkit-font-smoothing: antialiased;
  // -moz-osx-font-smoothing: grayscale;
  // text-align: center;
}
</style>
