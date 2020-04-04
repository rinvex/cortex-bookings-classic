module.exports = {
    scanForCssSelectors: [
        path.join(__dirname, 'node_modules/fullcalendar/**/*.js'),
        path.join(__dirname, 'node_modules/fullcalendar-scheduler/**/*.js'),
    ],
    whitelistPatterns: [],
    webpackPlugins: [],
    install: ['fullcalendar'],
    copy: [],
    mix: {
        css: [
            {input: 'resources/sass/fullcalendar.scss', output: 'public/css/fullcalendar.css'},
        ],
        js: [
            {input: 'resources/js/vendor/fullcalendar.js', output: 'public/js/fullcalendar.js'},
        ],
    },
};
