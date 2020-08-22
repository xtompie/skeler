import Vue from 'vue'

// style
import "./style.scss";

const App = {};

// components
App.components = {
  ...require('./components.js').default
};

// sanbox
if (process.env.NODE_ENV == "development") {
  const Sandbox = () => import('./Sandbox/components/Sandbox.vue')
  App.render = h => h(Sandbox)
}

new Vue(App).$mount('#app')
