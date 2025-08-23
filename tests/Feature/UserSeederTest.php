<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
});

test('user seeder creates admin user with owner role', function () {
    $admin = User::where('email', 'admin@example.com')->first();
    
    expect($admin)->not()->toBeNull();
    expect($admin->name)->toBe('Admin');
    expect($admin->hasRole('Owner'))->toBeTrue();
    expect(Hash::check('admin', $admin->password))->toBeTrue();
});

test('user seeder creates users for each role', function () {
    $expectedUsers = [
        ['name' => 'Manajer', 'email' => 'manajer@example.com', 'role' => 'Manajer', 'password' => 'manajer'],
        ['name' => 'Kasir', 'email' => 'kasir@example.com', 'role' => 'Kasir', 'password' => 'kasir'],
        ['name' => 'Admin Akuntansi', 'email' => 'adminakuntansi@example.com', 'role' => 'Admin Akuntansi', 'password' => 'adminakuntansi'],
        ['name' => 'Staf Gudang', 'email' => 'stafgudang@example.com', 'role' => 'Staf Gudang', 'password' => 'stafgudang'],
        ['name' => 'Pegawai', 'email' => 'pegawai@example.com', 'role' => 'Pegawai', 'password' => 'pegawai'],
    ];
    
    foreach ($expectedUsers as $expectedUser) {
        $user = User::where('email', $expectedUser['email'])->first();
        
        expect($user)->not()->toBeNull();
        expect($user->name)->toBe($expectedUser['name']);
        expect($user->hasRole($expectedUser['role']))->toBeTrue();
        expect(Hash::check($expectedUser['password'], $user->password))->toBeTrue();
    }
});

test('all users have unique uuids', function () {
    $users = User::all();
    $uuids = $users->pluck('uuid')->toArray();
    
    expect(count($uuids))->toBe(count(array_unique($uuids)));
    
    foreach ($uuids as $uuid) {
        expect($uuid)->not()->toBeNull();
        expect(\Illuminate\Support\Str::isUuid($uuid))->toBeTrue();
    }
});

test('total users count matches expected', function () {
    // 1 admin + 5 role users = 6 total users
    expect(User::count())->toBe(6);
});