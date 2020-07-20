<style lang="scss">
@import '../colors';
@import '../fonts';

.main {
  padding-top: 2rem;

  &__header {
    color: $base;
    font-family: Montserrat, sans-serif;
    font-size: 8rem;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;

    span {
      color: $secondary;
    }
  }
}
</style>

<template>
    <div class="main">
        <h1 class="main__header">Unforgettable <span>taste</span></h1>

        <Slider/>

        <Products/>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>
