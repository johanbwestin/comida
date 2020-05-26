<template>
  <div class="hamburger-menu">
    <div class="hamburger-container">
      <div class="hamburger" @click="onClick">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </div>
    </div>
    <div v-if="isActive" class="menu">
      <div class="menu-container">
        <div @click="onClick">
          <router-link to="/hem">
            <p class="menu-link">Hem</p>
          </router-link>
        </div>
        <div @click="onClick">
          <router-link to="/recept">
            <p class="menu-link">Recept</p>
          </router-link>
        </div>
        <div @click="onClick" v-if="this.$store.state.token">
          <router-link to="/recept/nytt">
            <p class="menu-link">Nytt recept</p>
          </router-link>
        </div>
        <div class="menu-item" @click="logOut(), onClick()" v-if="this.$store.state.token">
          <p class="menu-link">Logga Ut</p>
        </div>
        <div @click="onClick" class="menu-item" v-if="!this.$store.state.token">
          <router-link to="/logga-in">
            <p class="menu-link">Logga in</p>
          </router-link>
        </div>
        <div @click="onClick" v-if="this.$store.state.token">
          <router-link to="/profil">
            <p class="menu-link">Profil</p>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.hamburger-menu {
  overflow: visible;
  display: flex;
  margin-right: 20px;
  @include breakpoint(md) {
    display: none;
  }
  .hamburger-container {
    background-color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    height: 100%;
    width: 4rem;
    .hamburger {
      height: 50%;
      width: 3.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      align-items: center;
      @include breakpoint(sm) {
        height: 60%;
        width: 4rem;
      }
      .line {
        display: inline-block;
        background-color: $primary;
        height: 0.6rem;
        width: 80%;
        border-radius: 4px;
      }
    }
  }
  .menu {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 5;
    left: 0;
    top: 5rem;
    position: fixed;
    background-color: $bg;
    height: 100vh;
    width: 100%;
    .menu-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-bottom: 10rem;
      .menu-item {
        a {
          text-decoration: none;
          &:hover {
            text-decoration: underline;
            text-shadow: $shadow-hover;
          }
        }
      }
    }
  }
  .hamburger {
  }
}
</style>
<script>
export default {
  data() {
    return {
      shadowColor: "",
      beforeActive: false,
      isActive: false
    }
  },
  mounted() {
    // console.log(this.$waypointMap)
  },
  methods: {
    logOut() {
      localStorage.clear()
      this.$store.state.token = null
      this.$store.commit("checkStatus")
    },
    mouseOver() {
      this.shadowColor = "#515052"
    },
    mouseLeave() {
      this.shadowColor = ""
    },
    onClick() {
      if (!this.isActive) {
        this.isActive = !this.isActive
      } else {
        this.isActive = !this.isActive
      }
    }
  }
}
</script>