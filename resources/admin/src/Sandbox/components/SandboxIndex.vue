<template>
  <div>
    <div v-for="(item, index) in routes" :key="index">
      <router-link :to="item.path">{{ item.path }}</router-link>
    </div>
  </div>
</template>

<script>
import routes from '../../sandbox.js'

export default {
  data: () => { 
    return {routes: routes.routes}
  }
}
</script>
