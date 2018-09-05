<?php

Route::group(['module' => 'Usuarios', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Usuarios\Controllers'], function() {

    Route::get('usuarios', 'UsuariosController@index')->name('usuarios');
    Route::get('usuarios/novo', 'UsuariosController@create')->name('usuarios.novo');
    Route::get('usuarios/datatable', 'UsuariosController@dataTable')->name('usuarios.dataTable');

});
