/* eslint-disable no-unused-vars */
import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import router from './admin/routes'
import storex from './admin/store/store'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import VueSweetalert2 from 'vue-sweetalert2'
import App from './admin/components/App.vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import { httpSetup } from './admin/settings/settings'

window.Bus = new Vue({ name: 'Bus' })

httpSetup()

require('animate.css')
// require('babel-polyfill') // THROWING ERROR WTF
require('./admin/vue-mixins')

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)

Vue.config.productionTip = false

let store = new Vuex.Store(storex())

new Vue({
  components: {
    App
  },
  router,
  store
}).$mount('#app')
