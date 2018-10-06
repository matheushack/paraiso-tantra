<?php

Route::group(['prefix' => 'servicos', 'module' => 'Services', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Services\Controllers'], function() {

    Route::get('/', 'ServicesController@index')->name('services');
    Route::get('datatable', 'ServicesController@dataTable')->name('services.dataTable');
    Route::get('novo', 'ServicesController@create')->name('services.create');
    Route::post('salvar', 'ServicesController@store')->name('services.store');
    Route::get('editar/{id}', 'ServicesController@edit');
    Route::post('atualizar', 'ServicesController@update')->name('services.update');
    Route::post('deletar/{id}', 'ServicesController@destroy')->name('services.destroy');

});
