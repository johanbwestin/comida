<template>
  <nav :class="{ 'scrolled': !view.atTopOfPage}" class="main-menu">
    <ul class="menu">
      <router-link class="logo-container" to="/hem">
        <span class="line"></span>
        <h2 class="logo">Comida</h2>
        <span class="line"></span>
      </router-link>
      <div class="menu-item-container">
        <!-- <li class="menu-item">
          <router-link to="/sök">
            <p class="menu-link">Sök</p>
          </router-link>
        </li>-->
        <li class="menu-item" v-for="item in menuItems" :key="item.ID">
          <router-link :to="'/' + item.title.toLowerCase()">
            <p class="menu-link">{{ item.title }}</p>
          </router-link>
        </li>
        <li class="menu-item" v-if="this.$store.state.token">
          <router-link to="/recept/nytt">
            <p class="menu-link">Nytt Recept</p>
            <!-- <img class="icon" alt="List" src="../assets/media/svg/list.svg" /> -->
          </router-link>
        </li>
        <li class="menu-item" @click="logOut" v-if="$store.state.isLoggedIn">
          <!-- <router-link to="/"> -->
          <p class="menu-link">Logga Ut</p>
          <!-- </router-link> -->
        </li>
        <li class="menu-item" v-if="!$store.state.isLoggedIn">
          <router-link to="/logga-in">
            <p class="menu-link">Logga in</p>
          </router-link>
        </li>
        <li v-if="this.$store.state.token" class="menu-item">
          <!-- <router-link to="/"> -->
          <img class="user" alt="User" src="../assets/media/svg/user.svg" />
          <!-- </router-link> -->
        </li>
      </div>
    </ul>
    <ul class="mobile-menu">
      <li>
        <!-- <router-link to="/"> -->
        <p>Recept</p>
        <!-- </router-link> -->
      </li>
      <li>
        <!-- <router-link to="/"> -->
        <p>Matlista</p>
        <!-- </router-link> -->
      </li>
      <li>
        <!-- <router-link to="/"> -->
        <p>Sparat</p>
        <!-- </router-link> -->
      </li>
      <li>
        <!-- <router-link to="/"> -->
        <p>Hem</p>
        <!-- </router-link> -->
      </li>
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
      margin-left: 50px;
      color: $primary;
      text-decoration: none;
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
      display: flex;
      flex-direction: row;
      list-style-type: none;
      margin-right: 25px;
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
export default {
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
        // console.log(this.$route)
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