<?php

use Illuminate\Database\Seeder;
use App\Modules\Users\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users[] = [
            'name' => 'Matheus Hack',
            'img_profile' => 'assets/app/media/img/users/eu.jpg',
            'email' => 'matheushackdiniz@hotmail.com',
            'password' => 'Diniz05102014'
        ];

        foreach($users as $user){
            $userCount = User::where('email', '=', $user['email'])->count();

            if($userCount == 0)
                User::create($user);
        }
    }
}
