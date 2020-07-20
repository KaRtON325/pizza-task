const UserPlugin = {
    install(Vue, options) {
        // We call Vue.mixin() here to inject functionality into all components.
        Vue.mixin({
            // Anything added to a mixin will be injected into all components.
            methods: {
                isAuthorized: function() {
                    return false
                }
            }
        });
    }
};

export default UserPlugin;