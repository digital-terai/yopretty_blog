const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Fo development Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
if(mix.inProduction()) {
    mix.sass('resources/sass/vendor.scss','public/website/css/');
    mix.sass('resources/sass/admin/vendor.scss', 'public/cms/css/')
}
mix.sass('resources/sass/app.scss', 	 'public/website/css/');
mix.sass('resources/sass/admin.scss', 'public/cms/css/');


mix.js('resources/js/vendor.js',            'public/website/js');
mix.js('resources/js/app.js',               'public/website/js');
mix.js('resources/js/store.js',             'public/website/js');
mix.js('resources/js/cmsvendor.js',         'public/cms/js/cmsvendor.js');
mix.js('resources/js/cms.js',               'public/cms/js/cms.js');
mix.js('resources/js/header.js',            'public/cms/js/header.js');
mix.js('resources/js/lara-file-manager.js', 'public/cms/js');


//if (mix.inProduction()) {
    mix.version();
//}

mix.browserSync({
    host: 'localhost',
    port: 8000,
    proxy: 'http://127.0.0.1:8000/'
});

