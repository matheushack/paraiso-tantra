<?php

Route::group(['prefix' => 'contas-a-pagar', 'module' => 'Bills', 'middleware' => ['web', 'auth', 'admin'], 'namespace' => 'App\Modules\Bills\Controllers'], function() {

    Route::get('/', 'BillsController@index')->name('bills');
    Route::post('datatable', 'BillsController@dataTable')->name('bills.dataTable');
    Route::get('novo', 'BillsController@create')->name('bills.create');
    Route::post('salvar', 'BillsController@store')->name('bills.store');
    Route::get('editar/{id}', 'BillsController@edit');
    Route::post('atualizar', 'BillsController@update')->name('bills.update');
    Route::post('deletar/{id}', 'BillsController@destroy')->name('bills.destroy');

});

Route::group(['prefix' => 'fornecedores', 'module' => 'Bills', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Bills\Controllers'], function() {

    Route::get('/', 'ProvidersController@index')->name('providers');
    Route::get('datatable', 'ProvidersController@dataTable')->name('providers.dataTable');
    Route::get('novo', 'ProvidersController@create')->name('providers.create');
    Route::post('salvar', 'ProvidersController@store')->name('providers.store');
    Route::get('editar/{id}', 'ProvidersController@edit');
    Route::post('atualizar', 'ProvidersController@update')->name('providers.update');
    Route::post('deletar/{id}', 'ProvidersController@destroy')->name('providers.destroy');
    Route::post('buscar', 'ProvidersController@search')->name('providers.search');

});

