<?php

use Illuminate\Database\Seeder;
use App\Modules\Accounts\Models\Accounts;
use App\Modules\Accounts\Constants\AccountTypes;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts[] = [
            'name' => 'Cofre',
            'type' => 'I'
        ];

        $accounts[] = [
            'name' => 'Itau',
            'type' => 'B',
            'bank_id' => 341,
            'account_type' => AccountTypes::CHECKING_ACCOUNT,
            'agency_number' => '0001',
            'account_number' => '141214'
        ];

        foreach($accounts as $account){
            $accountCount = Accounts::where('name', '=', $account['name'])
                ->count();

            if($accountCount == 0)
                Accounts::create($account);
        }
    }
}
