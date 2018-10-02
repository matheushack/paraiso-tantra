<?php

Route::group(['module' => 'Profiles', 'middleware' => ['web'], 'namespace' => 'App\Modules\Profiles\Controllers'], function() {

    Route::resource('Profiles', 'ProfilesController');

});
