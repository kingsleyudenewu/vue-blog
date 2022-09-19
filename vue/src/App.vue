<script setup>
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
<!--  <div>-->
<!--      <HelloWorld msg="Vite + Vue" />-->
<!--  </div>-->
    <router-view :key="$route.path"></router-view>


</template>

<style scoped>

</style>
