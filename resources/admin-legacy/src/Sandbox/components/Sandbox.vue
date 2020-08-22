<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
import Vue from 'vue'
import VueRouter from 'vue-router'
import SandboxRoutes from '../../sandbox.js'

Vue.use(VueRouter);

const routes = [
  {path: '/', component: () => import('./SandboxIndex.vue')},
  ...SandboxRoutes.routes
]

export default {
  router: new VueRouter({routes})
}
</script>
