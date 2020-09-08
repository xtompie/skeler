import Vue from 'vue'

Vue.config.productionTip = false
Vue.config.devtools = true
Vue.config.silent = true

// style
import "./style.scss";

// App
const App = {};

// components
App.components = require('./components.js').default;

// sanbox
if (process.env.NODE_ENV == "development") {
  const Sandbox = () => import('./Sandbox/components/Sandbox.vue')
  App.render = h => h(Sandbox)
}

new Vue(App).$mount('#app')
