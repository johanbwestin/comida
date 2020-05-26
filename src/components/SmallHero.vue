<template>
  <section class="small-hero-section" style>
    <div class="top" id="top"></div>
    <div v-if="title" class="header-text-container">
      <span class="line"></span>
      <h1 id="title">{{ title }}</h1>
      <span class="line"></span>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.small-hero-section {
  position: relative;
  height: 35vh;
  width: 100%;
  background-image: url("../assets/media/png/bg-img-full.jpg");
  background-size: 100%;
  background-position-y: 80%;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
  .top {
    position: absolute;
    top: 0;
  }
  .header-text-container {
    margin-top: 72px;
    display: flex;
    flex: 1;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    h1 {
      padding: 5px;
      color: $primary;
      margin-bottom: 10px;
      text-transform: capitalize;
    }
    .line {
      display: inline-block;
      width: 20px;
      height: 4px;
      background: $primary;
    }
  }
}
</style>
<script>
export default {
  props: {
    title: String
  },
  data() {
    return {}
  },
  mounted() {},
  methods: {}
}
</script>
