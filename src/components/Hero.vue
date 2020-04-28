<template>
  <section class="hero-section" style>
    <div class="header-text-container">
      <span class="line"></span>
      <h1>Comida</h1>
      <span class="line"></span>
    </div>
  </section>
</template>
<style lang="scss" scoped>
  .hero-section {
    height: 70vh;
    width: 100%;
    background-image: url("../assets/media/png/bg-img-full.jpg");
    background-size: 100%;
    background-position-y: 80%;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    .header-text-container {
      display: flex;
      flex: 1;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      h1 {
        padding: 5px;
        color: $primary;
        margin-bottom: 23px;
      }
      .line {
        display: inline-block;
        width: 25px;
        height: 4px;
        // margin-top: 8px;
        background: $primary;
      }
    }
  }
</style>
<script>
  export default {
    data() {
      return {
      }
    },
    mounted() {
    },
    methods: {
    },
  }
</script>