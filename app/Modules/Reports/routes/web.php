<?php

Route::group(['prefix'=> 'relatorios', 'module' => 'Reports', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Reports\Controllers'], function() {

    Route::get('/', function(){
        dd('reports');
    })->name('reports');

    Route::group(['prefix'=> 'atendimentos'], function(){
        Route::get('/', 'CallsReportController@index')->name('reports.calls');
        Route::post('filtro', 'CallsReportController@filter')->name('reports.calls.filter');
        Route::get('excel', 'CallsReportController@excel')->name('reports.calls.excel');
        Route::get('pdf', 'CallsReportController@pdf')->name('reports.calls.pdf');
    });

    Route::group(['prefix'=> 'clientes'], function(){
        Route::get('/', 'CustomersReportController@index')->name('reports.customers');
        Route::post('filtro', 'CustomersReportController@filter')->name('reports.customers.filter');
        Route::get('excel', 'CustomersReportController@excel')->name('reports.customers.excel');
        Route::get('pdf', 'CustomersReportController@pdf')->name('reports.customers.pdf');
    });

    Route::group(['prefix'=> 'comissao'], function(){
        Route::get('/', 'CommissionsReportController@index')->name('reports.commissions');
        Route::post('filtro', 'CommissionsReportController@filter')->name('reports.commissions.filter');
        Route::get('excel', 'CommissionsReportController@excel')->name('reports.commissions.excel');
        Route::get('pdf', 'CommissionsReportController@pdf')->name('reports.commissions.pdf');
    });

    Route::group(['prefix'=> 'extrato'], function(){
        Route::get('/', 'ExtractReportController@index')->name('reports.extract');
        Route::post('filtro', 'ExtractReportController@filter')->name('reports.extract.filter');
        Route::get('excel', 'ExtractReportController@excel')->name('reports.extract.excel');
        Route::get('pdf', 'ExtractReportController@pdf')->name('reports.extract.pdf');
    });

    Route::group(['prefix'=> 'contas'], function(){
        Route::get('/', 'AccountsReportController@index')->name('reports.accounts');
        Route::post('filtro', 'AccountsReportController@filter')->name('reports.accounts.filter');
        Route::get('excel', 'AccountsReportController@excel')->name('reports.accounts.excel');
        Route::get('pdf', 'AccountsReportController@pdf')->name('reports.accounts.pdf');
    });

});
