<template>
  <section class="home-section" style>
    <Hero title="Comida" />
    <div class="content">
      <Popular />
      <Latest />
    </div>
  </section>
</template>
<style lang="scss" scoped>
.home-section {
  width: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  position: relative;
  z-index: 1;
  .content {
    width: 60%;
    margin-top: 3rem;
  }
}
</style>
<script>
import Hero from "./Hero.vue"
import Popular from "./Popular.vue"
import Latest from "./Latest.vue"

export default {
  components: {
    Hero,
    Popular,
    Latest
  },

  data() {
    return {}
  },
  mounted() {},
  methods: {}
}
</script>