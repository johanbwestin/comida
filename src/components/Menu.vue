<template>
  <nav class="main-menu">
    <ul class="menu">
      <div class="logo-container">
        <span class="line"></span>
        <h2 class="logo">Comida</h2>
        <span class="line"></span>
      </div>
      <div class="menu-item-container">
        <li class="menu-item">
          <!-- <router-link to="/"> -->
            <img class="icon" alt="Search" src="../assets/media/svg/search.svg" />
          <!-- </router-link> -->
        </li>
        <li class="menu-item" v-for="item in menuItems" :key="item.ID">
          <router-link :to="'/' + item.title">
            <p>{{ item.title }}</p>
          </router-link>
        </li>
        <li class="menu-item" @click="logOut" v-if="$store.state.isLoggedIn">
          <!-- <router-link to="/"> -->
            <p>Logga Ut</p>
          <!-- </router-link> -->
        </li>
        <li class="menu-item" v-if="!$store.state.isLoggedIn">
          <router-link to="/logga-in">
            <p>Logga in</p>
          </router-link>
        </li>
        <li class="menu-item">
          <!-- <router-link to="/"> -->
            <img class="icon" alt="List" src="../assets/media/svg/list.svg" />
          <!-- </router-link> -->
        </li>
        <li class="menu-item">
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
  .main-menu {
    position: fixed;
    z-index: 3;
    top: 0;
    width: 100%;
    height: 5rem;
    background-color: $primary;
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
        .logo {
          padding: 5px;
          color: $bg;
          margin-bottom: 8px;
        }
        .line {
          display: inline-block;
          width: 20px;
          height: 3px;
          // margin-top: 8px;
          background: white;
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
          color: white;
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
            background-color: green;
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
        menuItems: []
      }
    },
    created() {
      this.$http.get('wp/v2/menu').then(res => {
        this.menuItems = res.data
        // console.log(this.menuItems)
      }, error => alert(error))
    },
    mounted() {
    },
    methods: {
      hamburgerHandler() {
      },
      logOut() {
        localStorage.clear()
        this.$store.state.token = null
        this.$store.commit('checkStatus')

      }
    },
  }
</script>