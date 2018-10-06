<?php

Route::group(['prefix' => 'salas', 'module' => 'Rooms', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Rooms\Controllers'], function() {

    Route::get('/', 'RoomsController@index')->name('rooms');
    Route::get('datatable', 'RoomsController@dataTable')->name('rooms.dataTable');
    Route::get('novo', 'RoomsController@create')->name('rooms.create');
    Route::post('salvar', 'RoomsController@store')->name('rooms.store');
    Route::get('editar/{id}', 'RoomsController@edit');
    Route::post('atualizar', 'RoomsController@update')->name('rooms.update');
    Route::post('deletar/{id}', 'RoomsController@destroy')->name('rooms.destroy');

});

