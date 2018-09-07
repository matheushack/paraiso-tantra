<?php

Route::group(['module' => 'Users', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Users\Controllers'], function() {

    Route::get('usuarios', 'UsersController@index')->name('users');
    Route::get('usuarios/novo', 'UsersController@create')->name('users.create');
    Route::get('usuarios/datatable', 'UsersController@dataTable')->name('users.dataTable');
    Route::post('usuarios/upload/foto/perfil', 'UsersController@pictureUpload')->name('users.upload.picture');

    Route::post('usuarios/salvar', 'UsersController@store')->name('users.store');

});
