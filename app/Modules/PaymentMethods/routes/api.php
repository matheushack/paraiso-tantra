<?php

Route::group(['module' => 'PaymentMethods', 'middleware' => ['api'], 'namespace' => 'App\Modules\PaymentMethods\Controllers'], function() {

    Route::resource('PaymentMethods', 'PaymentMethodsController');

});
