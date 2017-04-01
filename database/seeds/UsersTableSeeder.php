<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadminpass-'),
            'type' => 'superadmin',
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('adminpass-'),
            'type' => 'admin',
        ]);
        User::create([
            'name' => 'member',
            'email' => 'member@mail.com',
            'password' => bcrypt('memberpass-'),
            'type' => 'member',
        ]);
    }
}
