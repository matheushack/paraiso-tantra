<?php

Route::group(['prefix' => 'atendimentos', 'module' => 'Calls', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Calls\Controllers'], function() {

    Route::get('/', 'CallsController@index')->name('calls');
    Route::get('novo', 'CallsController@create')->name('calls.create');
    Route::get('calendario', 'CallsController@calendar')->name('calls.calendar');
    Route::get('editar/{id}', 'CallsController@edit')->name('calls.edit');
    Route::post('disponibilidade', 'CallsController@availability')->name('calls.availability');
    Route::post('salvar', 'CallsController@store')->name('calls.store');
    Route::post('atualizar', 'CallsController@update')->name('calls.update');
    Route::post('atualizar/financeiro', 'CallsController@updateFinancial')->name('calls.update.financial');
    Route::post('atualizar/pagamentos', 'CallsController@updatePayment')->name('calls.update.payment');
    Route::post('deletar/{id}', 'CallsController@destroy')->name('calls.destroy');

});
