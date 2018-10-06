<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 05/10/18
 * Time: 12:18
 */

namespace App\Services;


use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceLocations
{
    public function find(Request $request)
    {
        try {
            if (empty($request->input('cep')))
                throw new \Exception('Necessário informar um CEP válido');

            if(Cache::has($request->input('cep')))
                return response()->json([
                    'success' => true,
                    'cep' => Cache::get($request->input('cep'))
                ], 200);

            $location = Locations::where('cep', '=', $request->input('cep'))->first();

            if(empty($location)) {
                $viaCep = zipcode($request->input('cep'))->getObject();
                $location = new Locations();
                $location->cep = $viaCep->cep;
                $location->address = $viaCep->logradouro;
                $location->neighborhood = $viaCep->bairro;
                $location->city = $viaCep->localidade;
                $location->state = $viaCep->uf;

                $location->save();
            }

            $cep = Cache::forever($location->cep, $location);

            return response()->json([
                'success' => true,
                'cep' => $cep
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'success' => false
            ], 200);
        }
    }
}