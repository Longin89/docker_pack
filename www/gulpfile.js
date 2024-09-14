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






    /**********************************************************/
    /*  INCLUDE PHP PAGES, BOOTSTRAP, ACL, JQUERY & HTACCESS  */
    /**********************************************************/

    const php = (callback) => {
        return pipeline(
            src(["./dev/**/*.php"]),
            dest("./out"),
            browserSync.stream(),
            callback
        );
    };




    const acl = (callback) => {
        return pipeline(
            src("./dev/app/*.json",),
            dest("./out/app"),
            browserSync.stream(),
            callback
        );
    };




    const htaccess = (callback) => {
        return pipeline(
            src("./.htaccess"),
            dest("./out"),
            callback
        );
    };




    const stylesAddons = (callback) => {
        return pipeline(
            src(["./dev/css/bootstrap.min.css",
                 "./dev/css/splide.min.css"
            ]),
            dest("./out/css"),
            callback
        );
    };




    const jsAddons = (callback) => {
        return pipeline(
            src(["./dev/js/bootstrap.bundle.min.js",
                 "./dev/js/jquery-3.7.1.min.js",
                 "./dev/js/splide.min.js",
                 "./dev/js/splide-extension-auto-scroll.min.js"
            ]),
            dest("./out/js"),
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
                "./dev/scss/**/*.scss",
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
                "./dev/js/components/*.js"
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
            newer("./out/images"),
            webp(),
            src("./dev/images/src/*.*"),
            newer("./out/images"),
            imagemin(),
            dest("./out/images"),
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
            callback
        );
    };




    /***********************************/
    /*  TTF TO WOFF2 FONTS CONVERTING  */
    /***********************************/

    const fonts = (callback) => {
        return pipeline(
        src(["./dev/fonts/src/*.*",
             "./dev/fonts/*.ttf"
        ]),
            ttf2woff2(),
            dest("./out/fonts"),
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
            proxy: "localhost"
        });
        watch(["./dev/scss/**/*.scss"], styles);
        watch(["./dev/js/components/*.js"], scripts);
        watch(["./dev/app/*.json"], acl);
        watch(["./dev/images/src/*.*"], images);
        watch(["./dev/images/src/svg"], sprite);
        watch(["./dev/fonts/src/*.*"], fonts);
        watch(["./dev/**/*.php"], php);
        watch(["./out/**/*.*"]).on("change", browserSync.reload);
    };


    /********************/
    /*  EXPORT MODULES  */
    /********************/

    module.exports = {
        "default": parallel(php, styles, scripts, acl, images, sprite, watcher),
        "depends": series(fonts, stylesAddons, jsAddons, htaccess, images),
        "zip": series(zipfiles)
    };