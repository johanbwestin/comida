import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import store from './store'
import router from './router'

Vue.use(VueResource)
Vue.http.options.root = process.env.VUE_APP_API_URL
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
