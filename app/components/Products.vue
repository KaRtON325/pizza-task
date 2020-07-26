<style lang="scss">
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/buttons';
@import 'node_modules/bootstrap/scss/grid';
@import 'node_modules/bootstrap/scss/utilities';
@import 'node_modules/bootstrap/scss/modal';
@import '../colors';
@import '../fonts';

.products {
  margin-top: 5rem;
  margin-bottom: 5rem;
}

.product-container {
  display: inline-flex;
}

.product {
  display: flex;
  flex-direction: column;
  background-color: $base;
  border-radius: 2rem;
  text-decoration: none !important;

  &__image {
    display: block;
    width: 100%;
    padding: 1rem;

    &:focus,
    &.focus {
      box-shadow: none;
    }

    img {
      width: inherit;
      transition: 0.3s transform;

      &:hover {
        transform: scale(1.1);
      }
    }
  }

  &__content {
    flex: 1;
    padding: 4rem 3rem;
    color: $text;
  }

  &__title {
    margin-bottom: 3rem;
    font-family: Montserrat, sans-serif;
    font-size: 3rem;
    font-weight: bold;
  }

  &__text {
    font-size: 2rem;
  }

  &__prices {
    display: flex;
    justify-content: space-between;
    padding-bottom: 1rem;
  }

  &__price {
    font-size: 3.5rem;
    font-weight: bold;
  }

  &__buttons {
    display: flex;
    flex-direction: column;
    padding: 0 3rem 4rem;
  }

  &__button {
    width: 100%;
    padding: 1rem 3rem;
    border-radius: 2rem;
    font-size: 2rem;

    &:focus,
    &:active:focus {
      outline: 0;
    }
  }
}
</style>

<template>
    <b-row class="products mt-5">
        <b-col cols="4" v-for="product in products" :key="product.id" class="product-container">
            <article class="product mb-5">
                <b-button variant="link" href="#" @click="$bvModal.show('product-' + product.id)" to="#" class="product__image">
                    <img :src="product.image" alt="Product Image">
                </b-button>
                <main class="product__content">
                    <h2 class="product__title">{{ product.name }}</h2>
                    <p class="product__text">{{ product.description }}</p>
                </main>
                <footer class="product__buttons">
                    <div class="product__prices">
                        <span class="product__price" v-for="price in product.prices" :key="price.currency_id">
                            {{ getCurrencyPrice(price.value, price.symbol) }}
                        </span>
                    </div>
                    <b-button variant="outline-secondary" @click="$bvModal.show('product-' + product.id)" class="product__button">Select</b-button>
                </footer>
            </article>

            <ProductModal v-bind:product="product"/>
        </b-col>
    </b-row>
</template>

<script>
    window.Vue = require('vue');
    import { LayoutPlugin, ButtonPlugin, ModalPlugin, ListGroupPlugin } from 'bootstrap-vue'
    import {mapActions, mapState} from 'vuex'
    Vue.use(LayoutPlugin)
    Vue.use(ButtonPlugin)
    Vue.use(ModalPlugin)
    Vue.use(ListGroupPlugin)

    export default {
        computed: mapState({
            products: state => state.products.all
        }),
        methods: {
            ...mapActions('products', [
                'getAllProducts',
            ]),
        },
        created () {
            this.$store.dispatch('products/getAllProducts')
        },
        data() {
            return {

            }
        },
    }
</script>