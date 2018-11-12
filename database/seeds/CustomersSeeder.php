<?php

use Illuminate\Database\Seeder;
use App\Modules\Customers\Models\Customers;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers[] = [
            'name' => 'Matheus Teste',
            'email' => 'customer@customer.com',
            'phone' => '(11)9999-9999',
            'cell_phone' => '(11)99999-9999',
            'gender' => 'M',
        ];

        foreach($customers as $customer){
            $customerCount = Customers::where('name', '=', $customer['name'])->count();

            if($customerCount == 0)
                Customers::create($customer);
        }
    }
}
