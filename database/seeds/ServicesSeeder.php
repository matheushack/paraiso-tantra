<?php

use Illuminate\Database\Seeder;
use App\Modules\Services\Models\Services;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services[] = [
            'name' => 'Massagem 1',
            'description' => 'teste de massagem',
            'amount' => 300,
            'discount' => 10,
            'duration' => 30,
            'is_active' => 1

        ];

        foreach($services as $service){
            $serviceCount = Services::where('name', '=', $service['name'])
                ->count();

            if($serviceCount == 0)
                Services::create($service);
        }
    }
}
