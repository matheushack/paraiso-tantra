<?php

Route::group(['prefix' => 'clientes', 'module' => 'Customers', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Customers\Controllers'], function() {

    Route::get('/', 'CustomersController@index')->name('customers');
    Route::get('datatable', 'CustomersController@dataTable')->name('customers.dataTable');
    Route::get('novo', 'CustomersController@create')->name('customers.create');
    Route::post('salvar', 'CustomersController@store')->name('customers.store');
    Route::get('editar/{id}', 'CustomersController@edit');
    Route::post('atualizar', 'CustomersController@update')->name('customers.update');
    Route::post('deletar/{id}', 'CustomersController@destroy')->name('customers.destroy');
    Route::post('buscar', 'CustomersController@search')->name('customers.search');

});
