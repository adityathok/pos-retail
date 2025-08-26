<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'PT. Retail Indonesia',
                'type' => 'string',
                'description' => 'Nama perusahaan yang akan ditampilkan di sistem'
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Contoh No. 123, Jakarta Pusat, DKI Jakarta 10110',
                'type' => 'string',
                'description' => 'Alamat lengkap perusahaan'
            ],
            [
                'key' => 'company_leader',
                'value' => 'Budi Santoso',
                'type' => 'string',
                'description' => 'Nama pimpinan perusahaan'
            ],
            [
                'key' => 'company_phone',
                'value' => '021-1234567',
                'type' => 'string',
                'description' => 'Nomor telepon perusahaan'
            ],
            [
                'key' => 'company_email',
                'value' => 'info@retailindonesia.com',
                'type' => 'string',
                'description' => 'Email perusahaan'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
