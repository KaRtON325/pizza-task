<style lang="scss">
@import '../global';
</style>

<template>
    <div class="main">
        <h1 class="main__header">About <span>us</span></h1>

        <div class="about-page mb-5">
            <b-jumbotron header="Pizza task" lead="Yii2 featuring Vue">
                <p>If you want to see our products, please visit the site's menu</p>
                <b-button variant="primary" href="/">Show me menu</b-button>
            </b-jumbotron>
        </div>
    </div>
</template>

<script>
    window.Vue = require('vue');
    import { JumbotronPlugin } from 'bootstrap-vue'
    Vue.use(JumbotronPlugin)

    export default {
        data() {
            return {

            }
        }
    }
</script>
