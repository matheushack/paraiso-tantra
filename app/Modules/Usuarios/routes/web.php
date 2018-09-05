<?php

Route::group(['module' => 'Usuarios', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Usuarios\Controllers'], function() {

    Route::resource('usuarios', 'UsuariosController');

});
