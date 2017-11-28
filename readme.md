[![Build Status](https://travis-ci.org/mwazovzky/taggable.svg?branch=master)](https://travis-ci.org/mwazovzky/taggable)

[![Coverage Status](https://coveralls.io/repos/github/mwazovzky/taggable/badge.svg?branch=master)](https://coveralls.io/github/mwazovzky/taggable?branch=master)

<h2 align="center">
	<img src="https://laravel.com/assets/img/components/logo-laravel.svg">
</h2>

### Project: mwazovzky\taggable

### Description
Laravel Package. Makes any model taggable.

#### Version: 0.0.1
#### Change log:
0.0.1 initial project scaffolding<br>

#### Installation.

1. Pull the package into Laravel project
```
composer require mwazovzky/taggable
```

2. For Laravel 5.4 or below register package service provider at `/config/app.php`.<br>
Package will be auto-registered for Laravel 5.5 and above.
```
// file config/app.php

...
'providers' => [
...
\MWazovzky\Taggable\TaggableServiceProvider::class
...
];
...
```

3. Run database migration to create `taggables` table
```
$ php artisan migrate
```

4. Use trait Taggable for every Model that can be tagged.<br>
```
use \Mikewazovzky\Taggable\Taggable;
```

5. Run artisan command to publish package assets to
 `/resources/assets/js/components/taggable/Tags.vue` folder:
```
$ php artisan vendor:publish --tag=assets
```
7. Published vue component are:
`<tags>` -
8. Register components:
```
// file /resources/assets/js/app.js

Vue.component('tags', require('./components/taggable/Tags.vue'));
```
Component usage
```
<tags :model={{ $model }}></tags>
```
