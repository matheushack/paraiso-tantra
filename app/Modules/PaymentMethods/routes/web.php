<?php

Route::group(['prefix' => 'formas-pagamento', 'module' => 'PaymentMethods', 'middleware' => ['web', 'auth', 'admin'], 'namespace' => 'App\Modules\PaymentMethods\Controllers'], function() {

    Route::get('/', 'PaymentMethodsController@index')->name('payments');
    Route::get('novo', 'PaymentMethodsController@create')->name('payments.create');
    Route::get('editar/{id}', 'PaymentMethodsController@edit');
    Route::get('datatable', 'PaymentMethodsController@dataTable')->name('payments.dataTable');
    Route::post('salvar', 'PaymentMethodsController@store')->name('payments.store');
    Route::post('atualizar', 'PaymentMethodsController@update')->name('payments.update');
    Route::post('deletar/{id}', 'PaymentMethodsController@destroy')->name('payments.destroy');

});
