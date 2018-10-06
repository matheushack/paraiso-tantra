<?php

Route::group(['prefix' => 'funcionarios', 'module' => 'Employees', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Employees\Controllers'], function() {

    Route::get('/', 'EmployeesController@index')->name('employees');
    Route::get('datatable', 'EmployeesController@dataTable')->name('employees.dataTable');
    Route::get('novo', 'EmployeesController@create')->name('employees.create');
    Route::post('salvar', 'EmployeesController@store')->name('employees.store');
    Route::get('editar/{id}', 'EmployeesController@edit');
    Route::post('atualizar', 'EmployeesController@update')->name('employees.update');
    Route::post('deletar/{id}', 'EmployeesController@destroy')->name('employees.destroy');

});
