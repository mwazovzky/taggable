<?php

Route::namespace('MWazovzky\Taggable\Http')
    ->middleware(['web', 'auth'])
    ->group(function () {
        Route::resource('/tags', 'TagsController');
    });
