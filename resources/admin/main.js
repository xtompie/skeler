import Vue from 'vue'

const App = {};

// components
App.components = {
  ...require('./components.js').default
};

new Vue(App).$mount('#app')
