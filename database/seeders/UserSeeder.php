<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
        $admin->assignRole('Owner');

        // Create user for each role
        $roles = ['Owner', 'Manajer', 'Kasir', 'Admin Akuntansi', 'Staf Gudang', 'Pegawai'];
        
        foreach ($roles as $roleName) {
            $username = strtolower(str_replace(' ', '', $roleName));
            
            // Skip Owner as admin already has this role
            if ($roleName === 'Owner') {
                continue;
            }
            
            $user = User::create([
                'name' => $roleName,
                'email' => $username . '@example.com',
                'password' => Hash::make($username),
            ]);
            
            $user->assignRole($roleName);
        }
    }
}