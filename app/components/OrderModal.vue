<style lang="scss">
@import '../fonts';
@import '../bootstrap';

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
</style>

<template>
    <b-modal centered id="order-modal" class="order-modal" hide-footer hide-header>
        <b-button class="modal-close" @click="$bvModal.hide('order-modal')">
            <svg viewBox="0 0 24 24" class="modal-close__icon">
                <title>Close</title>
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M18.3 5.71c-.39-.39-1.02-.39-1.41 0L12 10.59 7.11 5.7c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L10.59 12 5.7 16.89c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L12 13.41l4.89 4.89c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4z" />
            </svg>
        </b-button>
        <div class="d-block text-center">
            <span class="h1">Thank you for the order!</span>
        </div>
    </b-modal>
</template>

<script>
    window.Vue = require('vue');
    import VueRouter from 'vue-router'
    import { ModalPlugin } from 'bootstrap-vue'
    import get from 'lodash/get';
    import 'vue-popperjs/dist/vue-popper.css';
    Vue.use(VueRouter)
    Vue.use(ModalPlugin)

    export default {
        mounted() {
            let modal = get(this.$route.params, 'modal', false);
            if (modal) {
                this.$bvModal.show(modal)
            }
        },
        data() {
            return {

            }
        },
    }
</script>