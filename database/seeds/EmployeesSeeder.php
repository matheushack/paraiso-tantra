<?php

use Illuminate\Database\Seeder;
use App\Modules\Employees\Models\Employees;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees[] = [
            'name' => 'Brena',
            'cpf' => '965.907.160-48',
            'gender' => 'F',
            'birth_date' => '1989-10-25',
            'email' => 'customer@customer.com',
            'phone' => '(11)2305-1814',
            'cell_phone' => '(11)99878-2809',
            'color' => '#c6007d',
            'commission' => 50,
            'observation' => 'Sem observação',
            'is_access_system' => 0

        ];

        foreach($employees as $employee){
            $employeeCount = Employees::where('name', '=', $employee['name'])->count();

            if($employeeCount == 0)
                Employees::create($employee);
        }
    }
}
