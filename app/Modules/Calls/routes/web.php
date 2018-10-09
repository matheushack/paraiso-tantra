<?php

Route::group(['module' => 'Calls', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Calls\Controllers'], function() {

    Route::get('atendimentos', 'CallsController@index')->name('calls');
    Route::get('atendimentos/calendario', 'CallsController@calendar')->name('calls.calendar');
    Route::post('disponibilidade', 'CallsController@availability')->name('calls.availability');
    Route::post('salvar', 'CallsController@store')->name('calls.store');

});