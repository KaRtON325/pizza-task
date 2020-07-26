<style lang="scss">
@import '../colors';
@import '../fonts';
@import '../global';

.cart-page {
  padding: 4rem;
  background-color: $base;
  border-radius: 2rem;
}
</style>

<template>
    <div class="main">
        <h1 class="main__header"><span>Cart</span></h1>

        <div v-if="cartProducts.length" class="cart-page mb-5">
            <CartTable/>
            <OrderForm/>
        </div>

        <div class="empty-text" v-else>
            Your cart is<span> empty</span>
        </div>
    </div>
</template>

<script>
    import { mapState } from "vuex";


    export default {
        computed: mapState({
            cartProducts: state => state.cart.items
        }),
        data() {
            return {

            }
        },
    }
</script>
