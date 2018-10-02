<?php

Route::group(['module' => 'Rooms', 'middleware' => ['api'], 'namespace' => 'App\Modules\Rooms\Controllers'], function() {

    Route::resource('Rooms', 'RoomsController');

});
