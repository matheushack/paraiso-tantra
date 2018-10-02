<?php

Route::group(['prefix' => 'servicos', 'module' => 'Services', 'middleware' => ['web'], 'namespace' => 'App\Modules\Services\Controllers'], function() {

    Route::get('/', 'ServicesController@index')->name('services');

});
