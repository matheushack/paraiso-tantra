<?php

Route::group(['prefix' => 'unidades', 'module' => 'Units', 'middleware' => ['web'], 'namespace' => 'App\Modules\Units\Controllers'], function() {

    Route::get('/', 'UnitsController@index')->name('units');
    Route::get('datatable', 'UnitsController@dataTable')->name('units.dataTable');
    Route::get('novo', 'UnitsController@create')->name('units.create');
    Route::post('salvar', 'UnitsController@store')->name('units.store');
    Route::get('editar/{id}', 'UnitsController@edit');
    Route::post('atualizar', 'UnitsController@update')->name('units.update');
    Route::post('deletar/{id}', 'UnitsController@destroy')->name('units.destroy');

});
