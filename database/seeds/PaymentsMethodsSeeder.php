<?php

use Illuminate\Database\Seeder;
use App\Modules\PaymentMethods\Models\PaymentMethods;

class PaymentsMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments[] = [
            'name' => 'Dinheiro',
            'account_id' => 1
        ];

        $payments[] = [
            'name' => 'Cartão Débito',
            'account_id' => 2
        ];

        foreach($payments as $payment){
            $paymentCount = PaymentMethods::where('name', '=', $payment['name'])
                ->count();

            if($paymentCount == 0)
                PaymentMethods::create($payment);
        }
    }
}
