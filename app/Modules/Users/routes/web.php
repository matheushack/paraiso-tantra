<?php

Route::group(['prefix' => 'usuarios', 'module' => 'Users', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Users\Controllers'], function() {

    Route::get('/', 'UsersController@index')->name('users');
    Route::get('novo', 'UsersController@create')->name('users.create');
    Route::get('editar/{id}', 'UsersController@edit');
    Route::get('datatable', 'UsersController@dataTable')->name('users.dataTable');
    Route::post('salvar', 'UsersController@store')->name('users.store');
    Route::post('atualizar', 'UsersController@update')->name('users.update');
    Route::post('deletar/{id}', 'UsersController@destroy')->name('users.destroy');
});
