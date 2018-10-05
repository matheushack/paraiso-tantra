<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::post('cep/busca', function(\Illuminate\Http\Request $request){
    try {
        if (empty($request->input('cep')))
            throw new Exception('Necessário informar um CEP válido');

        $location = zipcode($request->input('cep'))->getArray();

        return response()->json([
            'success' => true,
            'cep' => $location
        ], 200);
    }catch (Exception $e){
        return response()->json([
            'success' => false
        ], 200);
    }
})->name('cep');
