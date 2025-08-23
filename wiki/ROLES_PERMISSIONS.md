# Roles & Permissions Documentation

## Overview
Proyek ini menggunakan Spatie Laravel Permission untuk mengelola role dan permission, serta UUID untuk identifikasi unik user.

## Roles yang Tersedia

1. **Owner** - Pemilik bisnis dengan akses penuh
2. **Manajer** - Manajer dengan akses manajemen
3. **Kasir** - Kasir untuk transaksi penjualan
4. **Admin Akuntansi** - Admin untuk mengelola keuangan
5. **Staf Gudang** - Staf untuk mengelola inventory
6. **Pegawai** - Pegawai umum dengan akses terbatas

## UUID Implementation

### Model User
Model User telah dilengkapi dengan:
- UUID field yang otomatis generate saat user dibuat
- HasUuid trait untuk reusability
- Route key menggunakan UUID untuk keamanan

### Trait HasUuid
```php
use App\Traits\HasUuid;

class YourModel extends Model
{
    use HasUuid;
}
```

## Role Management

### Assign Role ke User
```php
use App\Services\RolePermissionService;

$roleService = new RolePermissionService();
$user = User::find(1);

// Assign role
$roleService->assignRole($user, 'Owner');

// Check role
if ($roleService->hasRole($user, 'Owner')) {
    // User has Owner role
}
```

### Menggunakan di Controller
```php
public function index()
{
    // Check if user has specific role
    if (auth()->user()->hasRole('Owner')) {
        // Owner access
    }
    
    // Check multiple roles
    if (auth()->user()->hasAnyRole(['Owner', 'Manajer'])) {
        // Owner or Manager access
    }
}
```

### Middleware untuk Route Protection
```php
// Di routes/web.php
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Multiple roles
Route::middleware(['auth', 'role:Owner,Manajer'])->group(function () {
    Route::get('/management', [ManagementController::class, 'index']);
});
```

### Blade Templates
```blade
@role('Owner')
    <p>Hanya Owner yang bisa melihat ini</p>
@endrole

@hasanyrole('Owner|Manajer')
    <p>Owner atau Manajer bisa melihat ini</p>
@endhasanyrole

@unlessrole('Pegawai')
    <p>Semua kecuali Pegawai bisa melihat ini</p>
@endunlessrole
```

## Database Structure

### Users Table
- `id` - Primary key
- `uuid` - Unique identifier (UUID v4)
- `name` - User name
- `email` - User email
- `password` - Hashed password
- `created_at` - Timestamp
- `updated_at` - Timestamp

### Permission Tables (Spatie)
- `roles` - Menyimpan role
- `permissions` - Menyimpan permission
- `model_has_roles` - Relasi user-role
- `model_has_permissions` - Relasi user-permission
- `role_has_permissions` - Relasi role-permission

## Commands

### Seeding Roles
```bash
php artisan db:seed --class=RoleSeeder
```

### Migration
```bash
php artisan migrate
```

## Best Practices

1. **Gunakan UUID untuk route parameters** untuk keamanan
2. **Selalu check role di middleware** sebelum akses controller
3. **Gunakan RolePermissionService** untuk operasi role yang kompleks
4. **Cache role checks** jika diperlukan untuk performa
5. **Buat permission yang spesifik** untuk kontrol akses yang granular

## Troubleshooting

### Role tidak ditemukan
- Pastikan role sudah di-seed dengan `RoleSeeder`
- Check spelling role name (case sensitive)

### UUID tidak generate
- Pastikan model menggunakan `HasUuid` trait
- Check apakah `bootHasUuid()` method dipanggil

### Middleware tidak bekerja
- Pastikan middleware sudah diregister di `bootstrap/app.php`
- Check route definition dan parameter middleware