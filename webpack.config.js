const path = require('path');

const PATHS = {
    source: path.join(__dirname, 'app'),
    build: path.join(__dirname, 'web')
};

module.exports = {
    watch: true,
    entry: PATHS.source + 'app.js',
    mode: "development",
    output: {
        path: PATHS.build,
        filename: 'app.js'
    },
    externals: {
        jquery: 'jQuery'
    }
};
