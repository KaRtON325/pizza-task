<style lang="scss">
@import '../fonts';
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/tooltip';

// Modal

.modal-dialog {
  max-width: 50%;
  margin: 0 auto;
}

.modal-content {
  border-radius: 2rem;
}

.modal-close {
  position: absolute;
  top: -6rem;
  right: -6rem;
  display: flex;
  padding: 0.5rem;
  border-radius: 50%;

  &__icon {
    width: 4rem;
    height: 4rem;
  }
}

// Modal content

.product-modal {
  &__image {
    width: 100%;

    img {
      width: inherit;
    }
  }

  &__title {
    margin-bottom: 2rem;
    font-family: Montserrat, sans-serif;
    font-size: 4rem;
    font-weight: bold;
  }

  &__text {
    margin: 1rem 0;
    font-size: 2rem;
  }

  &__buttons {
    font-family: Montserrat, sans-serif;

    .btn {
      font-size: 2rem;
    }
  }
}

// Popper

.popper {
  padding: 2rem;
  box-shadow: rgb(172, 153, 153) 0 0 20px 0;
}
</style>

<template>
    <b-modal centered v-if="product" v-bind:id="'product-' + product.id" class="product-modal" hide-footer hide-header>
        <b-button class="modal-close" @click="$bvModal.hide('product-' + product.id)">
            <svg viewBox="0 0 24 24" class="modal-close__icon">
                <title>Close</title>
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M18.3 5.71c-.39-.39-1.02-.39-1.41 0L12 10.59 7.11 5.7c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L10.59 12 5.7 16.89c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L12 13.41l4.89 4.89c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4z" />
            </svg>
        </b-button>
        <b-row>
            <b-col cols="8">
                <div class="product-modal__image"><img :src="product.image" alt="Product Image"></div>
            </b-col>
            <b-col cols="4">
                <div class="product-modal__title"><span>{{ product.name }}</span></div>
                <b-list-group v-if="product.product_properties" class="product-modal__props">
                    <b-list-group-item v-for="productProperty in product.product_properties" :key="productProperty.id" class="d-flex justify-content-between align-items-center">
                        {{ productProperty.property.name }}
                        <span>{{ productProperty.value }}</span>
                    </b-list-group-item>
                </b-list-group>
                <p class="product-modal__text">{{ product.description }}</p>

                <popper>
                    <div class="popper" role="tooltip">
                        {{ _get(cartProducts.find(cartProduct => cartProduct.id === product.id), 'quantity', 0) }}
                    </div>

                    <b-button-group slot="reference" v-bind:id="'product-' + product.id + '-buttons'" class="product-modal__buttons">
                        <b-button
                            :disabled="!_get(cartProducts.find(cartProduct => cartProduct.id === product.id), 'quantity', 0)"
                            @click="removeProductFromCart(product)"
                        >
                            &minus;
                        </b-button>
                        <b-button href="/cart" @click="addProductToCart(product)">Checkout</b-button>
                        <b-button @click="addProductToCart(product)">&plus;</b-button>
                    </b-button-group>
                </popper>
            </b-col>
        </b-row>
    </b-modal>
</template>

<script>
    window.Vue = require('vue');
    import { LayoutPlugin, ModalPlugin, ListGroupPlugin, ButtonGroupPlugin } from 'bootstrap-vue'
    import { mapActions, mapState } from 'vuex'
    import get from 'lodash/get';
    import Popper from 'vue-popperjs';
    import 'vue-popperjs/dist/vue-popper.css';
    Vue.use(LayoutPlugin)
    Vue.use(ModalPlugin)
    Vue.use(ListGroupPlugin)
    Vue.use(ButtonGroupPlugin)

    export default {
        computed: mapState({
            cartProducts: state => state.cart.items
        }),
        methods: {
            ...mapActions('cart', [
                'addProductToCart',
                'removeProductFromCart'
            ]),
            _get(object, search, defaultValue) {
                return get(object, search, defaultValue)
            }
        },
        props: {
            product: { required: true },
        },
        components: {
            'popper': Popper
        },
        mounted() {
            let anchor = location.hash.substr(1)
            if (anchor) {
                this.$router.replace({ path: window.location.pathname })
                this.$bvModal.show(anchor)
            }
        },
        data() {
            return {

            }
        },
    }
</script>