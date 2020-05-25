<template>
  <section class="login-section" style>
    <div class="login-container">
      <div class="form-container">
        <div class="header-container">
          <span class="line"></span>
          <h3>Inloggning</h3>
          <span class="line"></span>
        </div>
        <form action>
          <div class="input-container">
            <label class="w3-text-blue">E-mail</label>
            <input v-model="user.username" placeholder="E-mail" type="text" name="mail" />
            <p v-if="errMsg.username" class="validation-error">{{errMsg.username}}</p>
          </div>
          <div class="input-container">
            <label class="w3-text-blue">Lösenord</label>
            <input v-model="user.password" placeholder="Password" type="text" name="password" />
            <p v-if="errMsg.password" class="validation-error">{{errMsg.password}}</p>
          </div>
        </form>
        <div class="button-container">
          <button class="login-btn" @click="onSubmit">
            <p>Logga in</p>
          </button>
          <p>
            Inte medlem? Registrera
            <a href="http://localhost/comida/admin/registrera/">här!</a>
          </p>
          <p>
            Eller fortsätt som
            <router-link to="/hem">gäst</router-link>
          </p>
        </div>
        <div class="error-container" v-if="$store.state.message">
          <p class="error">{{strippedContent($store.state.message)}}</p>
        </div>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.login-section {
  height: 100vh;
  width: 100%;
  background-image: url("../assets/media/png/bg-img-full.jpg");
  background-size: cover;
  background-position-y: 30%;
  .login-container {
    position: fixed;
    z-index: 2;
    background-color: rgba(255, 255, 255, 0.4);
    // position: fixed;
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
      height: 46vh;
      width: 25%;
      background-color: $bg;
      -webkit-box-shadow: 0 8px 38px -6px $p-primary;
      -moz-box-shadow: 0 8px 38px -6px $p-primary;
      box-shadow: 0 8px 38px -6px $p-primary;
      form {
        display: flex;
        flex-direction: column;
        width: 100%;
        .input-container {
          position: relative;
          margin: {
            left: auto;
            right: auto;
            top: 1rem;
          }
          width: 70%;
          .validation-error {
            position: absolute;
            top: 3.5rem;
            color: red;
          }
          input {
            margin-bottom: 0.3rem;
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
      .error-container {
        display: flex;
        justify-content: center;
        .error {
          width: 90%;
          top: 3.5rem;
          color: red;
        }
      }
      .header-container {
        justify-content: center;
        align-items: center;
        display: flex;
        height: 4rem;
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
}
</style>
<script>
export default {
  data() {
    return {
      user: {
        username: null,
        password: null
      },
      errMsg: {
        username: null,
        password: null
      }
    }
  },
  mounted() {},
  methods: {
    onSubmit() {
      console.log(this.validateForm())
      if (this.validateForm()) {
        this.$store.commit("userLogin", this.user)
      } else {
        if (this.user.username === null) {
          this.errMsg.username = "Fyll i ditt användarnamn!"
        }
        if (this.user.password === null) {
          this.errMsg.password = "Fyll i ditt lösenord!"
        }
      }
    },
    validateForm() {
      if (!this.user.username || !this.user.password) {
        return false
      } else {
        return true
      }
    },
    strippedContent(content) {
      let regex = /(<([^>]+)>)/gi
      return content.replace(regex, "")
    }
  }
}
</script>