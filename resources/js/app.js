import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.prototype.$http = axios;
Vue.use(BootstrapVue)
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
