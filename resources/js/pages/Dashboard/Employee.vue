<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employee Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Employee Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Employee Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Dashboard untuk Pegawai. Akses informasi dan tugas harian Anda.</p>
            </div>
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Jam Kerja Hari Ini</h3>
                        <p class="text-2xl font-bold text-blue-600">0 Jam</p>
                    </div>
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Tugas Selesai</h3>
                        <p class="text-2xl font-bold text-green-600">0</p>
                    </div>
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Tugas Pending</h3>
                        <p class="text-2xl font-bold text-orange-600">0</p>
                    </div>
                    <PlaceholderPattern />
                </div>
            </div>
            
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Pegawai</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Sebagai Pegawai, Anda dapat:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">
                        <li>Melihat jadwal kerja</li>
                        <li>Mencatat kehadiran</li>
                        <li>Mengakses informasi perusahaan</li>
                        <li>Melaporkan tugas harian</li>
                        <li>Mengajukan cuti atau izin</li>
                    </ul>
                </div>
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>