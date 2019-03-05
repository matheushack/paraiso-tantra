<?php

Route::group(['prefix' => 'tarefas', 'module' => 'Tasks', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Tasks\Controllers'], function() {
    Route::get('/', 'TasksController@index')->name('tasks');
    Route::post('salvar', 'TasksController@store')->name('tasks.store');
    Route::post('backup/banco-de-dados', 'TasksController@database')->name('tasks.database');

});
