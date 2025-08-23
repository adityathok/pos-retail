# Agent Guide — POS Retail

## ⚙️ Teknologi
- **Backend:** Laravel 11  
- **Frontend:** Inertia.js + Vue 3  
- **Database:** MySQL/MariaDB  
- **UI:** TailwindCSS + Shadcn Vue
- **Auth:** Laravel Breeze (Inertia + Vue)  
- **Role & Permission:** Spatie Laravel Permission  

---

## 📝 Panduan Penulisan

### Laravel
- Gunakan **Eloquent Model** dengan relasi bawaan (`hasMany`, `belongsTo`).  
- Controller mengikuti **Resource Controller**.  
- Validasi input menggunakan **FormRequest**.  
- Routing dengan Inertia, contoh:

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});
```

## 📁 Folder Struktur
pos-retail/
├── app/
│   ├── Models/         # Eloquent Models
│   ├── Http/
│   │   ├── Controllers # Controller Resource
│   │   └── Requests    # FormRequest validation
│   └── Policies/       
├── database/
│   ├── migrations/     # Migrasi tabel
│   └── seeders/        # Data awal
├── resources/
│   ├── js/
│   │   ├── Pages/      # Halaman Vue (Inertia)
│   │   └── Components/ # Komponen Vue reusable
│   └── views/          # Blade minimal (untuk layout)
├── routes/
│   ├── web.php         # Routing Inertia
│   └── api.php         # Routing API (opsional)
├── wiki/               # Dokumentasi proyek (AI menaruh docs di sini)
└── tests/              # Unit & feature tests