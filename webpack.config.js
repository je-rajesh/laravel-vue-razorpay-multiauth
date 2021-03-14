const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
        fallback: {
            "path": require.resolve("path-browserify"),
            "https": require.resolve('https-browserify'),
            "stream": require.resolve('stream-browserify'),
            "crypto": require.resolve('crypto-browserify'),
            "http": require.resolve('stream-http'),
            "zlib": require.resolve("browserify-zlib"),
            "os": require.resolve("os-browserify"),
            "fs": false,
            "net": false,
            "tls": false,

        }
    },
};