<style lang="scss">
@import '../fonts';
@import '../colors';
@import '../global';
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/forms';
@import 'node_modules/bootstrap/scss/custom-forms';
@import 'node_modules/bootstrap/scss/utilities';

.form-horizontal {
  padding: 2rem;
  background-color: $base;
  border-radius: 2rem;
}

.login-button {
  padding: 1rem !important;
  border-radius: 2rem !important;
  font-family: Montserrat, sans-serif;
  text-transform: uppercase;
}
</style>

<template>
    <div class="main">
        <h1 class="main__header">Sign<span>up</span></h1>

        <div class="empty-text" v-if="is_logged_in">
            User was successfully <span> logged in</span>
        </div>
        <div class="form-horizontal mt-5" v-else>
            <div class="container">
                <p>Please fill out the following fields to signup:</p>

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
                        type="password"
                        id="password"
                        label="Password"
                        name="password"
                        v-model="values.password"
                        :error="errors.password"
                        error_text="Please fill your password in. Enter at least 6 characters."
                        @validate="validate('password')" />

                <FormInput
                        type="password"
                        id="password-confirm"
                        label="Confirm password"
                        name="password_confirm"
                        v-model="values.password_confirm"
                        :error="errors.password_confirm"
                        error_text="Please fill your password in again."
                        @validate="validate('password_confirm')" />

                <div class="clearfix">
                    <div class="col-sm-offset-4 col-lg-offset-3 col-sm-8 col-lg-9">
                        <b-button variant="primary" name="login-button" class="login-button row" @click="submitForm">Login</b-button>
                    </div>
                </div>
            </div>
        </div>

        <b-modal centered id="error-modal"><div v-html="signup_errors"></div></b-modal>
    </div>
</template>

<script>
    import { FormGroupPlugin, FormPlugin  } from 'bootstrap-vue'
    import isEmpty from 'lodash/isEmpty';
    import signupFormSchema from "../schemas/signupFormSchema.js";
    import { mapState,  mapActions } from 'vuex'
    Vue.use(FormGroupPlugin)
    Vue.use(FormPlugin)

    export default {
        computed: {
            ...mapState({
                is_logged_in: state => state.is_logged_in
            })
        },
        data() {
            return {
                signup_errors: false,
                values: {
                    email: "",
                    password: "",
                    password_confirm: "",
                },
                errors: {
                    email: null,
                    password: null,
                    password_confirm: null,
                },
            }
        },
        methods: {
            ...mapActions('access', [
                'checkUserAuth',
                'changeAccessToken',
            ]),
            validate(field) {
                signupFormSchema
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
                signupFormSchema
                    .validate(this.values, { abortEarly: false })
                    .then()
                    .catch(err => {
                        err.inner.forEach(err => {
                            this.errors = { ...this.errors, [err.path]: false }
                        });
                    });

                if (isEmpty(this.errors)) {
                    axios({
                        method: 'post',
                        url: '/api/public/signup',
                        responseType: 'json',
                        data: this.values
                    }).then((response) => {
                        if (response.data.status) {
                            this.$store.dispatch('access/changeAccessToken', response.data.access_token)
                            this.$store.dispatch('access/changeIsLoggedIn', true)
                            this.$router.push({ name: 'landing'})
                        } else {
                            this.signup_errors = response.data.errors;
                            this.$bvModal.show('error-modal')
                        }
                    })
                }
            },
        },
        created () {
            this.$store.dispatch('access/checkUserAuth')
        },
    }
</script>
