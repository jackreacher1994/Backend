<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
    	$this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(GroupSettingsTableSeeder::class);
    }
}
