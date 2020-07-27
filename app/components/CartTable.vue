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
    <b-table :fields="fields" :items="products" class="cart-table mb-5" responsive>
        <template v-slot:cell(image)="data">
            <b-button variant="link" @click="$bvModal.show('product-' + data.item.id)" class="cart-item__image">
                <img :src="data.item.image" alt="Product Image">
            </b-button>
        </template>

        <template v-slot:cell(name)="data">
            <b-button variant="link" @click="$bvModal.show('product-' + data.item.id)" class="cart-item__name">{{ data.item.name }}</b-button>
        </template>

        <template v-slot:cell(quantity)="data" class="cart-item__quantity">
            <b-button @click="removeProductFromCart(data.item)">&minus;</b-button>
            <span>{{ data.value }}</span>
            <b-button @click="addProductToCart(data.item)">&plus;</b-button>
        </template>

        <template v-slot:cell(prices)="data" class="cart-item__prices">
            <div class="cart-item__prices">
                <span class="cart-item__price" v-for="price in data.value" :key="price.currency_id">
                    {{ getCurrencyPrice(price.value, price.symbol) }}
                </span>
            </div>
        </template>

        <template v-slot:cell(totals)="data">
            <div class="cart-item__totals">
                <span class="cart-item__price" v-for="price in data.value" :key="price.currency_id">
                    {{ getCurrencyPrice(price.value, price.symbol) }}
                </span>
            </div>
        </template>
    </b-table>
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
                fields: [
                    {
                        key: 'image',
                        label: '',
                        sortable: false,
                    },
                    {
                        key: 'name',
                        label: 'Name',
                        sortable: true,
                    },
                    {
                        key: 'quantity',
                        label: 'Quantity',
                        sortable: true,
                    },
                    {
                        key: 'prices',
                        label: 'Price',
                        sortable: true,
                    },
                    {
                        key: 'totals',
                        label: 'Total',
                        sortable: true,
                    },
                ],
            }
        },
    }
</script>