<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

test('user automatically generates a UUID', function () {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    expect($user->uuid)->not()->toBeNull();
    expect(Str::isUuid($user->uuid))->toBeTrue();
});

test('user can be assigned a role', function () {
    $user = User::factory()->create();
    $role = Role::create(['name' => 'Test Role']);

    $user->assignRole('Test Role');

    expect($user->hasRole('Test Role'))->toBeTrue();
    expect($user->roles)->toHaveCount(1);
});

test('user can have multiple roles', function () {
    $user = User::factory()->create();
    Role::create(['name' => 'Owner']);
    Role::create(['name' => 'Manajer']);

    $user->assignRole(['Owner', 'Manajer']);

    expect($user->hasRole('Owner'))->toBeTrue();
    expect($user->hasRole('Manajer'))->toBeTrue();
    expect($user->hasAnyRole(['Owner', 'Manajer']))->toBeTrue();
    expect($user->roles)->toHaveCount(2);
});

test('user can be found by uuid', function () {
    $user = User::factory()->create();
    $foundUser = User::where('uuid', $user->uuid)->first();

    expect($foundUser)->not()->toBeNull();
    expect($foundUser->id)->toBe($user->id);
});

test('role seeder creates all required roles', function () {
    $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

    $expectedRoles = ['Owner', 'Manajer', 'Kasir', 'Admin Akuntansi', 'Staf Gudang', 'Pegawai'];

    foreach ($expectedRoles as $roleName) {
        expect(Role::where('name', $roleName)->exists())->toBeTrue();
    }

    expect(Role::count())->toBeGreaterThanOrEqual(count($expectedRoles));
});

test('owner can access admin routes', function () {
    $user = User::factory()->create();
    Role::create(['name' => 'Owner']);
    $user->assignRole('Owner');

    $response = $this->actingAs($user)->get('/admin/roles');

    $response->assertStatus(200);
});

test('non-owner cannot access admin routes', function () {
    $user = User::factory()->create();
    Role::create(['name' => 'Pegawai']);
    $user->assignRole('Pegawai');

    $response = $this->actingAs($user)->get('/admin/roles');

    $response->assertStatus(403);
});

test('unauthenticated user cannot access admin routes', function () {
    $response = $this->get('/admin/roles');

    $response->assertRedirect('/login');
});

test('uuid is unique across users', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    expect($user1->uuid)->not()->toBe($user2->uuid);
    expect(Str::isUuid($user1->uuid))->toBeTrue();
    expect(Str::isUuid($user2->uuid))->toBeTrue();
});

test('user route key uses uuid', function () {
    $user = User::factory()->create();

    expect($user->getRouteKeyName())->toBe('uuid');
});
