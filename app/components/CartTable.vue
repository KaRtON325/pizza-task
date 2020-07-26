<style lang="scss">
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/tables';
@import '../colors.scss';

.cart-table {
  background-color: $base;

  &__head {
    font-family: Montserrat, sans-serif;
    font-size: 2rem;
    text-transform: uppercase;

    th {
      padding: 1.5rem !important;
    }
  }
}

.cart-item {
  &__image {
    display: block;
    width: 100%;
    max-width: 300px;
    max-height: 300px;

    img {
      width: inherit;
    }
  }

  &__name {
    color: inherit;
    font-family: Montserrat, sans-serif;
    font-size: 3rem;
    font-weight: bold;

    &:hover {
      color: inherit;
      text-decoration: none;
    }
  }

  &__quantity {
    font-size: 2rem;
  }

  &__prices,
  &__totals {
    font-size: 2rem;
  }

  &__totals {
    font-weight: bold;
  }

  &__price {
    padding: 0 1rem;
  }
}

.btn-link:focus,
.btn-link:active:focus {
  box-shadow: none;
  color: inherit;
  text-decoration: none;
}
</style>

<template>
    <b-table-simple class="cart-table mb-5" responsive>
        <b-thead class="cart-table__head">
            <b-tr>
                <b-th></b-th>
                <b-th>Name</b-th>
                <b-th>Quantity</b-th>
                <b-th>Price</b-th>
                <b-th>Total</b-th>
            </b-tr>
        </b-thead>
        <b-tbody>
            <b-tr class="cart-item" v-for="product in products" :key="product.id">
                <b-td>
                    <b-button variant="link" @click="$bvModal.show('product-' + product.id)" class="cart-item__image">
                        <img v-bind:src="product.image" alt="Product Image">
                    </b-button>
                </b-td>
                <b-th>
                    <b-button variant="link" @click="$bvModal.show('product-' + product.id)" class="cart-item__name">{{ product.name }}</b-button>
                </b-th>
                <b-td>
                    <div class="cart-item__quantity">
                        <b-button @click="removeProductFromCart(product)">&minus;</b-button>
                        <span>{{ product.quantity }}</span>
                        <b-button @click="addProductToCart(product)">&plus;</b-button>
                    </div>
                </b-td>
                <b-td>
                    <div class="cart-item__prices">
                        <span class="cart-item__price" v-for="price in product.prices">
                            {{ getCurrencyPrice(price.value, price.symbol)}}
                        </span>
                    </div>
                </b-td>
                <b-td>
                    <div class="cart-item__totals">
                        <span class="cart-item__price" v-for="price in product.totals">
                            {{ getCurrencyPrice(price.value, price.symbol)}}
                        </span>
                    </div>
                </b-td>

                <ProductModal v-bind:product="product"/>
            </b-tr>
            <b-tr class="cart-item">
                <b-td></b-td>
                <b-td>Delivery price</b-td>
                <b-td></b-td>
                <b-td></b-td>
                <b-td>
                    <div class="cart-item__prices">
                        <span class="cart-item__price" v-for="delivery_price in delivery_prices">
                            {{ getCurrencyPrice(delivery_price.value, delivery_price.symbol) }}
                        </span>
                    </div>
                </b-td>
            </b-tr>
            <b-tr class="cart-item">
                <b-td></b-td>
                <b-td>Total</b-td>
                <b-td></b-td>
                <b-td></b-td>
                <b-td>
                    <div class="cart-item__prices">
                        <span class="cart-item__price" v-for="total in totals">
                            {{ getCurrencyPrice(total.value, total.symbol) }}
                        </span>
                    </div>
                </b-td>
            </b-tr>
        </b-tbody>
        <b-tfoot>
            <b-tr>
                <b-th></b-th>
                <b-th>Name</b-th>
                <b-th>Quantity</b-th>
                <b-th>Price</b-th>
                <b-th>Total</b-th>
            </b-tr>
        </b-tfoot>
    </b-table-simple>
</template>

<script>
    window.Vue = require('vue');
    import { TablePlugin, ButtonPlugin } from 'bootstrap-vue'
    import { mapActions, mapState } from 'vuex'
    import AsyncComputed from 'vue-async-computed'
    Vue.use(ButtonPlugin)
    Vue.use(TablePlugin)
    Vue.use(AsyncComputed)

    export default {
        asyncComputed: mapState({
            products: async function (state) {
                // Process function only if it has loaded states
                if (!state.products.all.length) {
                    return;
                }
                // Cloning state object to prevent state editing
                let items = JSON.parse(JSON.stringify(state.cart.items))
                let stateProducts = state.products.all

                // Sending request to get real prices
                const params = new URLSearchParams()
                params.append('cartProducts', JSON.stringify(items))
                let response = await axios.get('/api/public/get-prices', {
                    params: params
                })

                let prices = response.data;
                this.delivery_prices = prices.delivery_prices;
                this.totals = prices.totals;
                // Merging product object and product prices object for data rendering
                items.map(function (cartProduct) {
                    return Object.assign(cartProduct, stateProducts.find(product => product.id === cartProduct.id), prices.products[cartProduct.id])
                })
                return items
            }
        }),
        methods: {
            ...mapActions('cart', [
                'addProductToCart',
                'removeProductFromCart'
            ]),
        },
        created () {
            this.$store.dispatch('products/getAllProducts')
        },
        data() {
            return {
                delivery_prices: [],
                totals: [],
            }
        },
    }
</script>