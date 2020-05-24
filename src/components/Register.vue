<template>
  <section class="login-section" style>
    <div class="form-container">
      <div class="header-container">
        <span class="line"></span>
        <h3>Registrera</h3>
        <span class="line"></span>
      </div>
      <form action>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Användarnamn</h4>
          </label>
          <input v-model="user.username" placeholder="Användarnamn" type="text" name="mail" />
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>E-mail</h4>
          </label>
          <input v-model="user.email" placeholder="E-mail" type="text" name="mail" />
        </div>
        <div class="input-container">
          <label class="w3-text-blue">
            <h4>Lösenord</h4>
          </label>
          <input v-model="user.password" placeholder="Password" type="text" name="password" />
        </div>
        <div class="terms-container">
          <label class="w3-text-blue">
            <p>vänligen acceptera användarvillkor</p>
          </label>
          <input v-model="terms" placeholder type="checkbox" name="terms" />
        </div>
        <div class="button-container">
          <router-link to="/logga-in">
            <button class="register-btn">
              <p>Logga in</p>
            </button>
          </router-link>
          <button class="login-btn" @click.prevent="onSubmit">
            <p>Registrera</p>
          </button>
        </div>
        <div class="error-message" v-if="$store.state.message">
          <p>{{strippedContent($store.state.message)}}</p>
        </div>
      </form>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.login-section {
  position: fixed;
  z-index: 2;
  background-color: rgba(0, 0, 0, 0.8);
  height: 100vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  .form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: absolute;
    // height: 45vh;
    width: 25%;
    background-color: $bg;
    form {
      display: flex;
      flex-direction: column;
      width: 100%;
      .terms-container {
        margin: {
          left: auto;
          right: auto;
          top: 0.5rem;
        }
        width: 70%;
      }
      .input-container,
      .button-container {
        margin: {
          left: auto;
          right: auto;
          top: 1rem;
        }
        width: 70%;
        input {
          height: 2.3rem;
          width: 100%;
        }
        .register-btn,
        .login-btn {
          border: none;
          background-color: $primary;
          p {
            font-size: 0.9rem;
            color: $bg;
            padding: {
              top: 5px;
              bottom: 5px;
              left: 8px;
              right: 8px;
            }
          }
        }
        .register-btn {
          margin-right: 0.5rem;
        }
      }
    }
    .header-container {
      justify-content: center;
      align-items: center;
      display: flex;
      height: 15%;
      width: 100%;
      background-color: $primary;
      h3 {
        padding: 5px;
        color: $bg;
        margin-bottom: 6px;
      }
      .line {
        display: inline-block;
        width: 20px;
        height: 3px;
        // margin-top: 8px;
        background: white;
      }
    }
  }
}
</style>
<script>
export default {
  data() {
    return {
      terms: false,
      user: {
        username: null,
        email: null,
        password: null,
        roles: ["contributor"]
      }
    }
  },
  mounted() {},
  methods: {
    onSubmit() {
      let userData = { user: this.user, terms: this.terms }
      console.log("on Submit: ", userData)

      this.$store.commit("registerUser", userData)
    },

    strippedContent(content) {
      let regex = /(<([^>]+)>)/gi
      return content.replace(regex, "")
    }
  }
}
</script>