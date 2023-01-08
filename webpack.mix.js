const mix = require("laravel-mix")
const tailwindcss = require("tailwindcss")
const path = require("path")


mix
    .js("resources/app/app.js", "public/build/js/app.js")
    .sass("resources/assets/scss/app.scss", "public/build/css/app.css")
    .vue({runtimeOnly: true})
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('tailwind.config.js'),
        ],
    })
    .autoload({
        "cash-dom": ["cash"]
    })
    .webpackConfig({
        output: {
            chunkFilename: 'build/js/[name].js?id=[chunkhash]',
        },
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                'vue$': 'vue/dist/vue.runtime.esm.js',
                '~': [
                    path.resolve('resources'),
                ]
            },
        },
    })
    .extract()
    .version()
