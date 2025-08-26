<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';

interface Props {
    userRoles: string[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Selamat datang di sistem retail management.</p>
            </div>
            
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Role Tidak Dikenali
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Anda memiliki role: <strong>{{ userRoles.join(', ') }}</strong></p>
                            <p>Silakan hubungi administrator untuk mengatur akses dashboard yang sesuai.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Akses Terbatas</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Dashboard khusus belum tersedia</p>
                    </div>
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Hubungi Admin</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Untuk pengaturan role yang tepat</p>
                    </div>
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Profil Anda</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola pengaturan akun</p>
                    </div>
                    <PlaceholderPattern />
                </div>
            </div>
            
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Sistem</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Role yang tersedia dalam sistem:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">
                        <li><strong>Owner</strong> - Akses penuh ke semua fitur</li>
                        <li><strong>Manajer</strong> - Mengelola operasional harian</li>
                        <li><strong>Kasir</strong> - Memproses transaksi penjualan</li>
                        <li><strong>Admin Akuntansi</strong> - Mengelola keuangan</li>
                        <li><strong>Staf Gudang</strong> - Mengelola inventori</li>
                        <li><strong>Pegawai</strong> - Akses dasar sistem</li>
                    </ul>
                </div>
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>