<template>
    <div>
        <div v-inertia="'admin.orders.index'"></div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['view'],
    mounted() {
      console.log('aqui')
    }
  };
  </script>