<template>
  <nav :class="{ 'scrolled': !view.atTopOfPage}" class="main-menu">
    <ul class="menu">
      <router-link class="logo-container" to="/hem">
        <span class="line"></span>
        <h2 class="logo">Comida</h2>
        <span class="line"></span>
      </router-link>
      <div class="menu-item-container">
        <li class="menu-item" v-for="item in menuItems" :key="item.ID">
          <router-link :to="'/' + item.title.toLowerCase()">
            <p class="menu-link">{{ item.title }}</p>
          </router-link>
        </li>
        <li class="menu-item" v-if="this.$store.state.token">
          <router-link to="/recept/nytt">
            <p class="menu-link">Nytt recept</p>
            <!-- <img class="icon" alt="List" src="../assets/media/svg/list.svg" /> -->
          </router-link>
        </li>
        <li class="menu-item" @click="logOut" v-if="this.$store.state.token">
          <!-- <router-link to="/"> -->
          <p class="menu-link">Logga ut</p>
          <!-- </router-link> -->
        </li>
        <li class="menu-item" v-if="!this.$store.state.token">
          <router-link to="/logga-in">
            <p class="menu-link">Logga in</p>
          </router-link>
        </li>
        <li v-if="this.$store.state.token" class="menu-item">
          <router-link to="/profil">
            <img class="user" alt="User" src="../assets/media/svg/user.svg" />
          </router-link>
        </li>
      </div>
      <hamburger-menu class="hamburger" />
    </ul>
  </nav>
</template>
<style lang="scss" scoped>
.scrolled {
  -webkit-box-shadow: 0 8px 38px -6px $p-primary;
  -moz-box-shadow: 0 8px 38px -6px $p-primary;
  box-shadow: 0 8px 38px -6px $p-primary;
}
.main-menu {
  position: fixed;
  z-index: 3;
  top: 0;
  width: 100%;
  height: 5rem;
  background-color: white;
  .menu {
    height: 100%;
    display: flex;
    flex-direction: row;
    list-style-type: none;
    .logo-container {
      display: flex;
      flex: 1;
      flex-direction: row;
      align-items: center;
      // margin-left: 50px;
      color: $primary;
      text-decoration: none;
      margin-left: 20px;
      @include breakpoint(md) {
        margin-left: 50px;
      }
      .logo {
        padding: 5px;
        color: $bg;
        margin-bottom: 8px;
        color: $primary;
      }
      .line {
        display: inline-block;
        width: 20px;
        height: 3px;
        // margin-top: 8px;
        background: $primary;
      }
    }
    .menu-item-container {
      flex: 1;
      align-items: center;
      justify-content: flex-end;
      flex-direction: row;
      list-style-type: none;
      margin-right: 25px;
      display: none;
      @include breakpoint(md) {
        display: flex;
      }
      .menu-item {
        margin-left: 20px;
        margin-right: 20px;
        padding-left: 5px;
        padding-right: 5px;
        white-space: nowrap;
        color: $primary;
        fill: $primary;
        a {
          color: $primary;
          text-decoration: none;
        }
        .menu-link {
          color: $primary;
        }
        .icon {
          width: 1.2rem;
          display: flex;
          justify-content: center;
        }
        .user {
          display: flex;
          justify-content: center;
          height: 3rem;
        }
        &:hover {
          text-decoration: underline;
        }
      }
    }
  }
  .mobile-menu {
    display: none;
  }
}
</style>
<script>
import HamburgerMenu from "./HamburgerMenu.vue"

export default {
  components: {
    HamburgerMenu
  },
  data() {
    return {
      view: {
        atTopOfPage: true
      },
      menuItems: []
    }
  },
  created() {
    this.$http.get("wp/v2/menu").then(
      res => {
        this.menuItems = res.data
      },
      error => alert(error)
    )
  },
  beforeMount() {
    window.addEventListener("scroll", this.handleScroll)
  },
  mounted() {},
  methods: {
    handleScroll() {
      // when the user scrolls, check the pageYOffset
      if (window.pageYOffset > 0) {
        // user is scrolled
        if (this.view.atTopOfPage) this.view.atTopOfPage = false
      } else {
        // user is at top of page
        if (!this.view.atTopOfPage) this.view.atTopOfPage = true
      }
    },
    hamburgerHandler() {},
    logOut() {
      localStorage.clear()
      this.$store.state.token = null
      this.$store.commit("checkStatus")
    }
  }
}
</script>