<style lang="scss">
@import '../colors';
@import '../fonts';
@import '../global';

.history-page {
  padding: 4rem;
  background-color: $base;
  border-radius: 2rem;
}
</style>

<template>
    <div class="main">
        <h1 class="main__header"><span>History</span></h1>

        <div v-if="is_logged_in && orders.length" class="history-page mb-5">
            <HistoryTable :orders="orders"/>
        </div>

        <div class="empty-text" v-else>
            Your history is<span> empty</span>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";


    export default {
        computed: {
            ...mapState({
                is_logged_in: state => state.access.is_logged_in
            })
        },
        mounted() {
            axios
                .get('/api/public/get-history?expand=order_products,order_products.product,currency')
                .then(response => this.orders = response.data)
        },
        data() {
            return {
                orders: [],
            }
        }
    }
</script>