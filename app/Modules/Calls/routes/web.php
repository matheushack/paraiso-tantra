<?php

Route::group(['prefix' => 'atendimentos', 'module' => 'Calls', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Calls\Controllers'], function() {

    Route::get('/', 'CallsController@index')->name('calls');
    Route::get('calendario', 'CallsController@calendar')->name('calls.calendar');
    Route::get('editar/{id}', 'CallsController@edit')->name('calls.edit');
    Route::post('disponibilidade', 'CallsController@availability')->name('calls.availability');
    Route::post('salvar', 'CallsController@store')->name('calls.store');

});
