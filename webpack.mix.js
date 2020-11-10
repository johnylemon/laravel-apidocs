const { mix } = require('laravel-mix');
require('laravel-mix-alias');

mix.alias({
	'@': './resources/js/components'
})
.sass('resources/sass/app.sass', 'publish/assets/css')
.js('resources/js/app.js', 'publish/assets/js')
.disableNotifications();
