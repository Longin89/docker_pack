    /****************************/
    /*  INITIALIZING OF CONSTS  */
    /****************************/

    const { src, dest, watch, parallel, series } = require("gulp");
    const { pipeline } = require("stream");
    const sass = require("sass");
    const autoprefixer = require("gulp-autoprefixer");
    const babel = require("gulp-babel");
    const browserSync = require("browser-sync").create();
    const concat = require("gulp-concat");
    const fileinclude = require("gulp-file-include");
    const gulpSass = require("gulp-sass");
    const imagemin = require("gulp-imagemin");
    const mainSass = gulpSass(sass);
    const newer = require("gulp-newer");
    const notify = require("gulp-notify");
    const plumber = require("gulp-plumber");
    const sourcemaps = require("gulp-sourcemaps");
    const svgsprite = require("gulp-svg-sprite");
    const ttf2woff2 = require("gulp-ttf2woff2");
    const webp = require("gulp-webp");
    const webpack = require("webpack");
    const webpackstream = require("webpack-stream");
    const zip = require("gulp-zip");






    /************************/
    /*  INCLUDE PHP PAGES  */
    /************************/

    const php = (callback) => {
        return pipeline(
            src(["./dev/**/*.php",
                "./.htaccess"
            ]),
            fileinclude({ prefix: "@@" }),
            dest("./out"),
            browserSync.stream(),
            callback
        );
    };


    const vendorParse = (callback) => {
        return pipeline(
            src("vendor/**/*.php",),
            fileinclude({ prefix: "@@" }),
            dest("./out/php"),
            browserSync.stream(),
            callback
        );
    };




    const aclParse = (callback) => {
        return pipeline(
            src("dev/app/*.json",),
            dest("./out/app"),
            browserSync.stream(),
            callback
        );
    };




    const htaccess = (callback) => {
        return pipeline(
            src("./.htaccess"),
            dest("./out"),
            browserSync.stream(),
            callback
        );
    };




    /*****************************************************************/
    /*  SCSS COMPILE/CONCAT/MAP FUNCTIONS(SPLIDE IS OFF BY DEFAULT)  */
    /*****************************************************************/

    const styles = (callback) => {
        return pipeline(
            src([
                //"./node_modules/@splidejs/splide/dist/css/splide.min.css",
                //'./node_modules/bootstrap/scss/bootstrap.scss',
                "./dev/scss/**/*.scss"
            ]),
            sourcemaps.init(),
            plumber({
                errorHandler: notify.onError(function(err) {
                    return {
                        title: "Styles error",
                        sound: false,
                        message: err.message
                    };
                })
            }),
            mainSass(),
            autoprefixer({
                cascade: false,
                grid: true,
                overrideBrowserslist: ["last 5 versions"]
            }),
            concat("style.min.css"),
            sourcemaps.write("./"),
            dest("./out/css"),
            browserSync.stream(),
            callback
        );
    };




    /******************************************************/
    /*  JS-FILES CONCAT/MINIFY(SPLIDE IS OFF BY DEFAULT)  */
    /******************************************************/

    const scripts = (callback) => {
        return pipeline(
        src([
                //"./node_modules/@splidejs/splide/dist/js/splide.js",
                "./dev/js/components/*.js",
            ]),
            plumber({
                errorHandler: notify.onError(function(err) {
                    return {
                        title: "JS error",
                        sound: false,
                        message: err.message
                    };
                })
            }),
            babel({
                presets: ["@babel/env"]
            }),
            webpackstream(require("./webpack.config.js")[1], webpack),
            dest("./out/js"),
            (browserSync.stream()),
            callback
        );
    };




    /*************************************/
    /*  IMGS MINIFY/CONVERTING/UPDATING  */
    /*************************************/

    const images = (callback) => {
        return pipeline(
        src("./dev/images/src/*.*"),
            src("./dev/images/src/*.*"),
            newer("./dev/images"),
            webp(),
            src("./dev/images/src/*.*"),
            newer("./dev/images"),
            imagemin(),
            dest("./out/images"),
            dest("./dev/images"),
            callback
        );
    };




    /****************************/
    /*  CONVERTING SVG-SPRITES  */
    /****************************/

    const sprite = (callback) => {
        return pipeline(
        src("./dev/images/src/svg/*.svg"),
            svgsprite({
                mode: {
                    stack: {
                        sprite: "../sprite.svg",
                        example: true
                    }
                }
            }),
            dest("./out/images/out"),
            dest("./dev/images/out"),
            callback
        );
    };




    /***********************************/
    /*  TTF TO WOFF2 FONTS CONVERTING  */
    /***********************************/

    const fonts = (callback) => {
        return pipeline(
        src("./dev/fonts/src/*.*"),
            src("./dev/fonts/*.ttf"),
            ttf2woff2(),
            dest("./out/fonts"),
            dest("./dev/fonts"),
            callback
        );
    };




    /*************************/
    /*  ARCHIVE THE PROJECT  */
    /*************************/

    const zipfiles = (callback) => {
        return pipeline(
            src("./out/**"),
            zip("out.zip"),
            dest("./"),
            callback
        );
    };




    /****************************************/
    /*  WATCHING FILES MODIFY & BROWSERSYNC */
    /****************************************/

    const watcher = () => {
        browserSync.init({
            proxy: "localhost",
            notify: false
        });
        watch(["./dev/scss/**/*.scss"], styles);
        watch(["./dev/images/src/*.*"], images);
        watch(["./dev/images/src/svg"], sprite);
        watch(["./dev/fonts/src/*.*"], fonts);
        watch(["./dev/js/components/*.js"], scripts);
        watch(["./dev/**/*.php"], php);
        watch(["./out/**/*.php"]).on("change", browserSync.reload);
    };


    /********************/
    /*  EXPORT MODULES  */
    /********************/

    module.exports = {
        "default": parallel(php, styles, scripts, images, sprite, watcher),
        "depends": series(fonts, vendorParse, htaccess, aclParse),
        "zip": series(zipfiles)
    };