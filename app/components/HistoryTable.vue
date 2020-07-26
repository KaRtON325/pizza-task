<style lang="scss">
@import '../bootstrap';

.products {
  display: table;
  width: 100%;
  margin: 0;
  table-layout: fixed;

  tr:first-child,
  tr:first-child td {
    border-top: none;
  }
}

.product__quantity {
  width: 20%;
}
</style>

<template>
    <div>
        <b-table :fields="fields" :items="orders" stacked>
            <!-- A virtual composite column -->
            <template v-slot:cell(products)="data">
                <b-tbody class="products">
                    <b-tr v-for="order_product in data.item.order_products" :key="order_product.id">
                        <b-td>{{ order_product.product.name }}</b-td>
                        <b-td class="product__quantity">{{ order_product.quantity }}</b-td>
                    </b-tr>
                </b-tbody>
            </template>
        </b-table>
    </div>
</template>

<script>
    import { TablePlugin } from 'bootstrap-vue'
    Vue.use(TablePlugin)

    export default {
        props: {
            orders: {required: true}
        },
        data() {
            return {
                fields: [
                    {
                        key: 'id',
                        label: 'Order ID',
                        sortable: true
                    },
                    {
                        key: 'first_name',
                        label: 'First name',
                        sortable: false
                    },
                    {
                        key: 'last_name',
                        label: 'Last name',
                        sortable: false
                    },
                    {
                        key: 'address',
                        label: 'Address',
                        sortable: true
                    },
                    {
                        key: 'email',
                        label: 'E-mail',
                        sortable: true
                    },
                    {
                        key: 'phone_number',
                        label: 'Phone number',
                        sortable: true
                    },
                    {
                        key: 'delivery_price',
                        label: 'Delivery price',
                        sortable: true,
                        formatter: (value, key, item) => {
                            return this.getCurrencyPrice(value, item.currency.symbol)
                        }
                    },
                    {
                        key: 'total',
                        label: 'Total',
                        sortable: true,
                        formatter: (value, key, item) => {
                            return this.getCurrencyPrice(value, item.currency.symbol)
                        }
                    },
                    {
                        key: 'created_at',
                        label: 'Created at',
                        sortable: true,
                        formatter: (value, key, item) => {
                            let date = new Date(value * 1000);
                            return date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                        }
                    },
                    {
                        key: 'products',
                        label: 'Products',
                        sortable: false
                    },
                ],
            }
        }
    }
</script>