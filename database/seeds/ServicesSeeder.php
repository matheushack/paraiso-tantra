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
            'name' => "Tantrica 90''",
            'description' => 'Massagem tantrica masculina',
            'amount' => 300,
            'discount' => 0,
            'duration' => 90,
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
