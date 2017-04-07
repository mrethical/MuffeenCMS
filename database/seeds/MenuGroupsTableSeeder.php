<?php

use Illuminate\Database\Seeder;
use App\Models\MenuGroup;
use App\Services\Menus;

class MenuGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Menus::getGroups() as $id => $name) {
            MenuGroup::create([
                'id' => $id,
                'name' => $name
            ]);
        }
    }
}
