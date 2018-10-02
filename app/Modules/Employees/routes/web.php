<?php

Route::group(['prefix' => 'funcionarios', 'module' => 'Employees', 'middleware' => ['web'], 'namespace' => 'App\Modules\Employees\Controllers'], function() {

    Route::get('/', 'EmployeesController@index')->name('employees');

});
