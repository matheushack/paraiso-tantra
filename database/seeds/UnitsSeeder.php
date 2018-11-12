<?php

use Illuminate\Database\Seeder;
use App\Modules\Units\Models\Units;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units[] = [
            'name' => 'Jardins',
            'cnpj' => '24.183.590/0001-11',
            'social_name' => 'Unidade Jardins',
            'cep' => '01403-002',
            'address' => 'Alameda Joaquim Eugênio de Lima',
            'number' => '1144',
            'complement' => 'Casa',
            'neighborhood' => 'Jardim Paulista',
            'city' => 'São Paulo',
            'state' => 'SP',
            'email' => 'brumattiago@gmail.com',
            'phone' => '(11)2305-1814',
            'cell_phone' => '(11)99999-9999',
            'operating_hours' => '[{"open": "08:00", "week": ["seg", "ter", "qua", "qui", "sex", "sab"], "close": "22:00"}]',
        ];

        foreach($units as $unity){
            $unityCount = Units::where('cnpj', '=', $unity['cnpj'])
                ->count();

            if($unityCount == 0)
                Units::create($unity);
        }
    }
}
