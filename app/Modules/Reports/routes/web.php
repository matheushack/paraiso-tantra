<?php

Route::group(['prefix'=> 'relatorios', 'module' => 'Reports', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Reports\Controllers'], function() {

    Route::get('/', function(){
        dd('reports');
    })->name('reports');

    Route::group(['prefix'=> 'clientes'], function(){
        Route::get('/', 'CustomersReportController@index')->name('reports.customers');
        Route::post('filtro', 'CustomersReportController@filter')->name('reports.customers.filter');
    });

});
