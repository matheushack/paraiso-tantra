<?php

Route::group(['prefix' => 'contas-a-pagar', 'module' => 'Bills', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Bills\Controllers'], function() {

    Route::get('/', 'BillsController@index')->name('bills');
    Route::get('datatable', 'BillsController@dataTable')->name('bills.dataTable');
    Route::get('novo', 'BillsController@create')->name('bills.create');
    Route::post('salvar', 'BillsController@store')->name('bills.store');
    Route::get('editar/{id}', 'BillsController@edit');
    Route::post('atualizar', 'BillsController@update')->name('bills.update');
    Route::post('deletar/{id}', 'BillsController@destroy')->name('bills.destroy');

});
