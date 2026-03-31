<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Msimamizi Mkuu'],
            ['name' => 'regional_admin', 'display_name' => 'Msimamizi wa Mkoa'],
            ['name' => 'broker', 'display_name' => 'Dalali'],
        ];

        foreach ($roles as $role) {
            \DB::table('roles')->insert($role);
        }
    }
}
