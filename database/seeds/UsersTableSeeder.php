<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->fullname = 'Nguyen Van An';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
