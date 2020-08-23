export default {
  install(Vue) {
    Vue.prototype.$admin = Vue.observable({
      drawer: false,
    });
  }
}
