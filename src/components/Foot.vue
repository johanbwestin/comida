<template>
  <section class="footer-section" style>
    <div class="arrow-container">
      <a class="circle" href="#top">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="26.451"
          height="19.638"
          viewBox="0 0 30.451 19.638"
          stroke="#ec4e20"
        >
          <g id="Group_82" data-name="Group 82" transform="translate(2.114 2.114)">
            <line
              id="Line_6"
              data-name="Line 6"
              y1="15.411"
              x2="12.983"
              transform="translate(0 0)"
              fill="none"
              stroke-linecap="round"
              stroke-width="4"
            />
            <path
              id="Path_118"
              data-name="Path 118"
              d="M12.983,15.411l-6.9-8.187L0,0"
              transform="translate(13.241 0)"
              fill="none"
              stroke-linecap="round"
              stroke-width="4"
            />
          </g>
        </svg>
      </a>
    </div>
    <div class="arrow"></div>
    <div class="footer-container">
      <div class="col-one">
        <h3>Information</h3>
        <ul>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
        </ul>
      </div>
      <div class="col-two">
        <h3>Information</h3>
        <ul>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
        </ul>
      </div>
      <div class="col-three">
        <h3>Information</h3>
        <ul>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
          <li>
            <p>Lorem Ipsum</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.footer-section {
  min-height: 50vh;
  background-color: $primary;
  position: relative;
  .arrow-container {
    position: absolute;
    top: -2.4rem;
    z-index: 1;
    height: 5rem;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    .circle {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: white;
      height: 2.8rem;
      width: 2.8rem;
      border-radius: 50%;
      border: 4px solid $primary;
      &:hover {
        background-color: $primary;
        svg {
          stroke: white;
        }
      }
      svg {
        margin-bottom: 3px;
      }
    }
  }
  .footer-container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-direction: column;
    padding-top: 4rem;
    padding-bottom: 4rem;
    text-align: center;
    @include breakpoint(sm) {
      text-align: start;
      flex-direction: row;
    }
    .col-one,
    .col-two,
    .col-three {
      margin-bottom: 1rem;
      @include breakpoint(sm) {
        margin-bottom: 0rem;
      }
      h3 {
        color: white;
      }
      ul {
        li {
          list-style: none;
          p {
            color: white;
          }
        }
      }
    }
  }
}
</style>
<script>
export default {
  data() {
    return {}
  },
  mounted() {},
  methods: {}
}
</script>