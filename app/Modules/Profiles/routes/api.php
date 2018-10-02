<?php

Route::group(['module' => 'Profiles', 'middleware' => ['api'], 'namespace' => 'App\Modules\Profiles\Controllers'], function() {

    Route::resource('Profiles', 'ProfilesController');

});
