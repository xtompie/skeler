import Vue from 'vue'
import Vuetify from './Vuetify/src/Vuetify'

Vue.config.productionTip = false
Vue.config.devtools = true
Vue.config.silent = true

// style
import "./style.scss";

// plugins
Object.values(require('./plugins.js').default).forEach((plugin) => Vue.use(plugin));

// App
const App = {components: {}};

// components
App.components = {...require('./components.js').default, ...App.components};

// vuetify
App.vuetify = Vuetify;
App.components = {...require('./vuetify.js').default, ...App.components};

// sanbox
if (process.env.NODE_ENV == "development") {
  const Sandbox = () => import('./Sandbox/components/Sandbox.vue')
  App.render = h => h(Sandbox)
}

new Vue(App).$mount('#app')
