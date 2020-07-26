<style lang="scss">
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/card';
@import 'node_modules/bootstrap/scss/forms';
@import 'node_modules/bootstrap/scss/custom-forms';
@import 'node_modules/bootstrap/scss/utilities';
@import 'node_modules/bootstrap/scss/list-group';
@import '../colors';
@import '../fonts';

.shipping-data legend {
  border: 0;
  font-family: Montserrat, sans-serif;
  text-transform: uppercase;
}

.form-control,
.col-form-label,
.custom-select {
  font-size: 2rem;
}

.order-form__submit {
  padding: 1rem;
  border-radius: 2rem;
  color: $base;
  font-family: Montserrat, sans-serif;
  font-size: 3rem;
  text-transform: uppercase;
}
</style>

<template>
    <div>
        <form id="oder-form" action="/api/order" @submit.prevent="submitForm(this)">
            <!-- User data start -->
            <div class="user-data">
                <FormInput
                        type="text"
                        id="first-name"
                        label="First name"
                        name="first_name"
                        v-model="values.first_name"
                        :error="errors.first_name"
                        error_text="Please fill your first name in."
                        @validate="validate('first_name')" />

                <FormInput
                        type="text"
                        id="last-name"
                        label="Last name"
                        name="last_name"
                        v-model="values.last_name"
                        :error="errors.last_name"
                        error_text="Please fill your last name in."
                        @validate="validate('last_name')" />

                <FormInput
                        type="email"
                        id="email"
                        label="E-mail"
                        name="email"
                        v-model="values.email"
                        :error="errors.email"
                        error_text="Please fill your email in."
                        @validate="validate('email')" />

                <FormInput
                        type="text"
                        id="phone"
                        label="Phone number"
                        name="phone_number"
                        v-model="values.phone_number"
                        :error="errors.phone_number"
                        error_text="Please fill your phone in. You can enter digits only. Enter at least 6 digits."
                        @validate="validate('phone_number')" />
            </div>
            <!-- User data end -->

            <!-- Shipping address card start -->
            <b-card class="shipping-data mt-5" bg-variant="light">
                <b-form-group
                        label-cols-lg="3"
                        label="Shipping Address"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="user-data__legend mb-0"
                >
                    <FormInput
                            type="text"
                            id="country"
                            label="Country"
                            label_align="right"
                            name="country"
                            v-model="values.country"
                            :error="errors.country"
                            error_text="Please fill your country in. Enter at least 3 letters."
                            @validate="validate('country')" />

                    <FormInput
                            type="text"
                            id="state"
                            label="State"
                            label_align="right"
                            name="state"
                            v-model="values.state"
                            :error="errors.state"
                            error_text="Please fill your state in. Enter at least 3 letters."
                            @validate="validate('state')" />

                    <FormInput
                            type="text"
                            id="city"
                            label="City"
                            label_align="right"
                            name="city"
                            v-model="values.city"
                            :error="errors.city"
                            error_text="Please fill your city in."
                            @validate="validate('city')" />

                    <FormInput
                            type="text"
                            id="street"
                            label="Street, house, flat"
                            label_align="right"
                            name="street"
                            v-model="values.street"
                            :error="errors.street"
                            error_text="Please fill your street, house and flat in. Enter at least 5 letters."
                            @validate="validate('street')" />
                </b-form-group>
            </b-card>
            <!-- Shipping address card end -->

            <FormSelect
                    v-if="values.currency_id"
                    class="mt-5"
                    type="text"
                    id="currency_id"
                    label="Currency"
                    label_align="left"
                    name="currency_id"
                    :options="currencies"
                    v-model="values.currency_id"
                    :error="errors.currency_id"
                    error_text="Please choose your payment currency."
                    @validate="validate('currency_id')" />

            <div class="clearfix mt-5">
                <b-button type="submit" class="order-form__submit float-right">Make an order</b-button>
            </div>
        </form>

        <b-modal centered id="error-modal">There was an error in your order creating. Please contact the site's master</b-modal>
    </div>
</template>

<script>
    import { FormGroupPlugin, FormPlugin, CardPlugin  } from 'bootstrap-vue'
    import orderFormSchema from "../schemas/orderFormSchema.js";
    import { mapActions, mapState } from "vuex";
    import isEmpty from 'lodash/isEmpty';
    Vue.use(FormGroupPlugin)
    Vue.use(FormPlugin)
    Vue.use(CardPlugin)

    export default {
        computed: {
            ...mapState({
                cartProducts: state => state.cart.items
            }),
        },
        methods: {
            ...mapActions('cart', [
                'clearCart'
            ]),
            validate(field) {
                orderFormSchema
                    .validate(this.values, { abortEarly: false })
                    .then(() => { this.errors = {} })
                    .catch(err => {
                        this.errors = {};
                        if (err.inner) {
                            err.inner.forEach(err => {
                                this.errors[err.path] = false
                            })
                        }
                    })
            },
            submitForm() {
                orderFormSchema
                    .validate(this.values, { abortEarly: false })
                    .then(() => { this.errors = {} })
                    .catch(err => {
                        err.inner.forEach(err => {
                            this.errors = { ...this.errors, [err.path]: false }
                        });
                    });

                if (isEmpty(this.errors)) {
                    this.values.products = JSON.stringify(this.cartProducts);
                    this.values.address = [this.values.country, this.values.state, this.values.city, this.values.street].join(', ');

                    axios({
                        method: 'post',
                        url: '/api/public/order',
                        responseType: 'json',
                        data: this.values
                    }).then((response) => {
                        if (response.data.status) {
                            this.$store.dispatch('cart/clearCart')
                            this.$router.push({ name: 'landing', params: { modal: 'order-modal' } })
                        } else {
                            this.$bvModal.show('error-modal')
                        }
                    })
                }
            },
        },
        mounted() {
            axios
                .get('/api/public/get-currencies')
                .then(response => {
                    this.currencies = response.data
                    this.values.currency_id = response.data.find(currency => currency.is_base === 1).id
                })
        },
        data() {
            return {
                currencies: [],
                values: {
                    first_name: "",
                    last_name: "",
                    email: "",
                    phone_number: "",
                    country: "",
                    state: "",
                    city: "",
                    street: "",
                    currency_id: "",
                    products: "",
                },
                errors: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    phone_number: null,
                    country: null,
                    state: null,
                    city: null,
                    street: null,
                    currency_id: null,
                },
            }
        },
    }
</script>