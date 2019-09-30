<?php

Route::group(['prefix' => 'contas', 'module' => 'Accounts', 'middleware' => ['web', 'auth', 'admin'], 'namespace' => 'App\Modules\Accounts\Controllers'], function() {

    Route::get('/', 'AccountsController@index')->name('accounts');
    Route::get('datatable', 'AccountsController@dataTable')->name('accounts.dataTable');
    Route::get('novo', 'AccountsController@create')->name('accounts.create');
    Route::post('salvar', 'AccountsController@store')->name('accounts.store');
    Route::get('editar/{id}', 'AccountsController@edit');
    Route::post('atualizar', 'AccountsController@update')->name('accounts.update');
    Route::post('deletar/{id}', 'AccountsController@destroy')->name('accounts.destroy');
    Route::post('transferencia', 'AccountsController@transfer')->name('accounts.transfer');

});
