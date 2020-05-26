<template>
  <section class="recipe-section" style>
    <SmallHero />
    <div class="content-container">
      <div class="recipe-container">
        <div class="header-container">
          <h2>Sidan kommer att vara tillgänglig inom kort!</h2>
        </div>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.recipe-section {
  width: 100%;
  // height: 95vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-bottom: 3rem;
  align-items: center;
  .content-container {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    min-height: 62vh;
    .recipe-container {
      margin-top: 3rem;
      width: 100%;
      .header-container {
        align-items: center;
        height: 15%;
        width: 100%;
        h3 {
          padding: 5px;
          color: $bg;
          margin-bottom: 6px;
        }
      }
    }
  }
}
</style>
<script>
import SmallHero from "./SmallHero.vue"

export default {
  components: {
    SmallHero
  },
  data() {
    return {
    }
  },
  mounted() {
    this.$store.state.loading = false
  },
  methods: {
  }
}
</script>