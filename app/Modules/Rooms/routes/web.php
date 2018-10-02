<?php

Route::group(['prefix' => 'salas', 'module' => 'Rooms', 'middleware' => ['web'], 'namespace' => 'App\Modules\Rooms\Controllers'], function() {

    Route::get('/', 'RoomsController@index')->name('rooms');

});
