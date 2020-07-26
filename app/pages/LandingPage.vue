<style lang="scss">
@import '../colors';
@import '../fonts';
@import '../global';
</style>

<template>
    <div class="main">
        <h1 class="main__header">Unforgettable <span>taste</span></h1>

        <Slider/>

        <Products/>

        <OrderModal/>
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
