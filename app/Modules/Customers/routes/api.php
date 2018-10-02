<?php

Route::group(['module' => 'Customers', 'middleware' => ['api'], 'namespace' => 'App\Modules\Customers\Controllers'], function() {

    Route::resource('Customers', 'CustomersController');

});
