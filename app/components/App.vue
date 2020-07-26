<style lang="scss">
@import '../bootstrap';
@import '../colors';
@import '../fonts';

html,
body {
  height: 100%;
}

body {
  background-color: $primary;
  color: $text;
  font-family: Lato, sans-serif;
}

#wrapper {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
}

#content {
  flex: 1 0 auto;
}

.not-found {
  display: block;
  margin-top: 6rem;
  color: $secondary;
  font-size: 5rem;
  font-weight: bold;
  text-align: center;
  text-transform: uppercase;

  span {
    color: $base;
  }
}
</style>

<template>
    <div id="wrapper">
        <DropdownMenu/>

        <div id="content" class="container">
            <transition>
                <router-view></router-view>
            </transition>
            <div class="text-center" v-if="this.$route.matched.length === 0">
                <span class="not-found">404 <span>Not Found</span></span>
            </div>
        </div>

        <Footer/>
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