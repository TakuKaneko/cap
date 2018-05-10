<template>
  <div class="section">
  <ul>
    <li v-for="(color, i) in colors">
      {{ color.id }} - {{ color.fruit }} - {{ color.color }}
    </li>
    </ul>
  </div>
</template>

<script>
  import http from '../services/http'

  export default {
    mounted() {
      this.fetchColors();
    },
    data() {
      return {
        colors: []
      }
    },
    methods: {
      fetchColors() {
        http.get('colors', res =>  {
          console.log(res);
          this.colors = res.data
        });
      }
    }
  }
</script>