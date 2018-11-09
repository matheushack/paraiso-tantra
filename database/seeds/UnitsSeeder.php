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
            'name' => 'Unidade 1',
            'cnpj' => '11.111.111/1111-11',
            'social_name' => 'Unidade Teste LTDA',
            'cep' => '07080-120',
            'address' => 'Rua Antonieta',
            'number' => '280',
            'complement' => 'Complemento',
            'neighborhood' => 'Picanço',
            'city' => 'Guarulhos',
            'state' => 'SP',
            'email' => 'unidade@unidade.com.br',
            'phone' => '(11)9999-9999',
            'cell_phone' => '(11)99999-9999',
            'operating_hours' => '[{"open": "11:1_", "week": ["seg", "ter", "qua"], "close": "12:12"}]',
        ];

        foreach($units as $unity){
            $unityCount = Units::where('cnpj', '=', $unity['cnpj'])
                ->count();

            if($unityCount == 0)
                Units::create($unity);
        }
    }
}
