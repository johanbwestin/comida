<template>
  <div id="app">
    <Menu />
    <div v-if="$store.state.loading" class="loader-bg">
      <hollow-dots-spinner
        :animation-duration="1200"
        :circles-num="3"
        :circle-size="15"
        color="#EC4E20"
      />
    </div>
    <routerView class="content-section" />
    <Foot />
  </div>
</template>
<style lang="scss">
#app {
  overflow-x: hidden;
  scroll-behavior: smooth;
  .content-section {
    padding-bottom: 10rem;
  }
  .loader-bg {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    z-index: 2;
    background-color: rgba(255, 255, 255, 0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    .hollow-dots-spinner {
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 20%;
      height: 20%;
    }
  }
}
</style>
<script>
import Menu from "./components/Menu.vue"
import Foot from "./components/Foot.vue"
import { HollowDotsSpinner } from "epic-spinners"

export default {
  name: "App",
  components: {
    Menu,
    Foot,
    HollowDotsSpinner
  },
  mounted() {
    if (this.$route.path === "/") {
      this.$router.push("/hem").catch(() => {})
    }
  }
}
</script>
