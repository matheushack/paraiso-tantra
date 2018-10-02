<?php

Route::group(['module' => 'Employees', 'middleware' => ['api'], 'namespace' => 'App\Modules\Employees\Controllers'], function() {

    Route::resource('Employees', 'EmployeesController');

});
