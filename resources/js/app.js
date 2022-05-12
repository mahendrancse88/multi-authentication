import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import '~/plugins'
import '~/components'
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
