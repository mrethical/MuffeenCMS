<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
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
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('adminpass-'),
            'type' => 'admin',
            'first_name' => 'Mary',
            'last_name' => 'Doe'
        ]);
        User::create([
            'name' => 'member',
            'email' => 'member@mail.com',
            'password' => bcrypt('memberpass-'),
            'type' => 'member',
            'first_name' => 'Peter',
            'last_name' => 'Doe'
        ]);
    }
}
