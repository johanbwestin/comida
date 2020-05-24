import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import store from './store'
import router from './router'

Vue.use(VueResource)

Vue.http.options.root = process.env.VUE_APP_API_URL

Vue.config.productionTip = false

Vue.directive('on-scroll', {
  inserted: function (el, binding) {
    let f = function (evt) {
      if (binding.value(evt, el)) {
        window.removeEventListener('scroll', f)
      }
    }
    window.addEventListener('scroll', f)
  }
})

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
