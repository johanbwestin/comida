<template>
  <div id="app">
    <Menu />
    <!-- <Hero /> -->
    <!-- <Home /> -->
    <!-- <Register />
    <HelloWorld msg="Welcome to Your Vue.js App"/>-->
        
    <div v-if="$store.state.loading" class="loader-bg">
      <hollow-dots-spinner
        :animation-duration="1200"
        :circles-num="3"
        :circle-size="15"
        color="#EC4E20"
      />
    </div>
    <routerView />
    <Foot />
  </div>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import Menu from "./components/Menu.vue"
import Foot from "./components/Foot.vue"
import { HollowDotsSpinner } from "epic-spinners"

export default {
  name: "App",
  components: {
    Menu,
    Foot,
    HollowDotsSpinner
    // HelloWorld,
  },
  mounted() {
    // console.log(this.$route.path)
    if (this.$route.path === "/") {
      this.$router.push("/hem").catch(() => {})
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
      .loader-bg {
      position: fixed;
      top: 0;
      left:0;
      height: 100vh;
      width: 100%;
      z-index: 2;
      background-color: rgba(255,255,255, 0.4);
      display: flex;
      justify-content: center;
      align-items: center;
      .hollow-dots-spinner {
        // display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 20%;
        height: 20%;
      }
    }
}
</style>
