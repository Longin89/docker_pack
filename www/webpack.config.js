const webpack = require("webpack");
const path = require("path");
const BannerPlugin = require("webpack").BannerPlugin;
const TerserPlugin = require("terser-webpack-plugin");


const config = {
    mode: "production",
    entry: {
        main: ["./dev/js/components/_vars.js", "./dev/js/components/_functions.js", "./dev/js/components/_main.js"]
    },
    output: {
        filename: "main.bundle.js",
        path: path.resolve(__dirname, "app"),
    },
    optimization: {
        minimizer: [new TerserPlugin({
          extractComments: false,
        })],
      },
    module: {
        rules: [{
            test: /\.css$/,
            use: ["style-loader", "css-loader"],
        }, ],
    },
};

const devConfig = {
    mode: "development",
    entry: {
        main: ["./dev/js/components/_vars.js", "./dev/js/components/_functions.js", "./dev/js/components/_main.js"]
    },
    output: {
        filename: "main.bundle.js",
        path: path.resolve(__dirname, "dev"),
        iife: false,
        libraryExport: "default"
    },
    devtool: "source-map",
    optimization: {
        minimize: false,
        splitChunks: {
            chunks: "all",
          },
    },
    plugins: [
        new BannerPlugin({
            raw: true,
            entryOnly: true,
            test: /\.js$/,
            include: /dev\/js/,
            banner: (filename) => {
                const name = path.basename(filename);
                return `/* ${name} */\n`;
            },
        }),
    ],
};

module.exports = [config, devConfig];