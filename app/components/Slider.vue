<style lang="scss">
.carousel-container {
  margin-top: 5rem;
}

.owl-carousel .owl-item img {
  border-radius: 2rem;
}

.owl-theme {
  &:hover,
  &:active {
    .owl-dots {
      opacity: 1;
    }
  }

  .owl-dots {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    opacity: 0;
    transform: translate(-50%, 0);
    transition: 0.3s opacity;

    .owl-dot {
      outline: none;
    }

    .owl-dot span,
    .owl-dot:hover span {
      background: #544c48;
    }

    .owl-dot.active span {
      background: #c5cace;
    }
  }
}
</style>

<template>
    <carousel v-if="banners" class="carousel-container" :autoplay="true" :items="1" :autoHeight="true" :nav="false" :loop="true" :margin="20">
        <a v-for="banner in banners" :href="banner.link"><img :src="banner.image" alt="Banner"/></a>
    </carousel>
</template>

<script>
    import carousel from 'vue-owl-carousel'

    export default {
        components: { carousel },
        data() {
            return {
                banners: null
            }
        },
        mounted() {
            axios
                .get('/api/get-banners')
                .then(response => this.banners = response.data);
        }
    }
</script>