const CurrencyPlugin = {
    install: function (Vue, options) {
        // Adding component options
        Vue.mixin({
            methods: {
                getCurrencyPrice(price, currency_symbol) {
                    return currency_symbol + Math.ceil(price * 100) / 100;
                }
            }
        })
    }
}

export default CurrencyPlugin;