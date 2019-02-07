<?php

Route::group(['prefix'=> 'relatorios', 'module' => 'Reports', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Reports\Controllers'], function() {

    Route::get('/', function(){
        dd('reports');
    })->name('reports');

    Route::group(['prefix'=> 'clientes'], function(){
        Route::get('/', 'CustomersReportController@index')->name('reports.customers');
        Route::post('filtro', 'CustomersReportController@filter')->name('reports.customers.filter');
        Route::get('excel', 'CustomersReportController@excel')->name('reports.customers.excel');
        Route::get('pdf', 'CustomersReportController@pdf')->name('reports.customers.pdf');
    });

    Route::group(['prefix'=> 'atendimentos'], function(){
        Route::get('/', 'CallsReportController@index')->name('reports.calls');
        Route::post('filtro', 'CallsReportController@filter')->name('reports.calls.filter');
        Route::get('excel', 'CallsReportController@excel')->name('reports.calls.excel');
        Route::get('pdf', 'CallsReportController@pdf')->name('reports.calls.pdf');
    });

});
