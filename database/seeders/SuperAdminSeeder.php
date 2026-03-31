<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tafuta ID ya super_admin kutoka kwenye table ya roles
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if ($superAdminRole) {
            User::create([
                'name' => 'Said Hassan', // Jina la msimamizi
                'phone' => '255743434305', // Namba yako katika format ya 255
                'email' => 'admin@dalalimkuu.co.tz', // Email ni nullable lakini ni vizuri iwepo
                'password' => Hash::make('password123'), // Weka password imara hapa
                'role_id' => $superAdminRole->id, // Anapewa Role ID ya Super Admin
                'region_id' => null, // Super admin hafungwi na mkoa mmoja
                'subscription_until' => now()->addYears(10), // Msimamizi hakatwi huduma
            ]);
            
            $this->command->info('Super Admin amesajiliwa kikamilifu!');
        } else {
            $this->command->error('Role ya super_admin haijapatikana! Hakikisha umerun RoleSeeder kwanza.');
        }
    }
}