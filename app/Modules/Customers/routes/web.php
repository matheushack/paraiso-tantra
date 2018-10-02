<?php

Route::group(['prefix' => 'clientes', 'module' => 'Customers', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Customers\Controllers'], function() {

    Route::get('/', 'CustomersController@index')->name('customers');

});
