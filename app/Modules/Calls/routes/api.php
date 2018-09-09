<?php

Route::group(['module' => 'Calls', 'middleware' => ['api'], 'namespace' => 'App\Modules\Calls\Controllers'], function() {

    Route::resource('Calls', 'CallsController');

});
