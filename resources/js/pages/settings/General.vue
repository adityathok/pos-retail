<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { toast } from "vue-sonner"
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'General settings',
        href: '/settings/general',
    },
];

// Form data
const form = ref({
    company_name: '',
    company_address: '',
    company_leader: '',
    company_phone: '',
    company_email: ''
});

const errors = ref({} as any);
const processing = ref(false);
const recentlySuccessful = ref(false);

// Load settings on mount
onMounted(async () => {
    try {
        const response = await fetch('/api/settings/general');
        const data = await response.json();
        
        form.value = {
            company_name: data.company_name || '',
            company_address: data.company_address || '',
            company_leader: data.company_leader || '',
            company_phone: data.company_phone || '',
            company_email: data.company_email || ''
        };
    } catch (error) {
        console.error('Error loading settings:', error);
        toast.error('Gagal memuat pengaturan');
    }
});

// Submit form
const submit = async () => {
    processing.value = true;
    errors.value = {};
    
    try {
        const response = await fetch('/api/settings/general', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(form.value)
        });
        
        const data = await response.json();
        
        if (response.ok) {
            recentlySuccessful.value = true;
            toast.success(data.message || 'Pengaturan berhasil disimpan');
            
            setTimeout(() => {
                recentlySuccessful.value = false;
            }, 2000);
        } else {
            if (data.errors) {
                errors.value = data.errors;
            }
            throw new Error(data.message || 'Gagal menyimpan pengaturan');
        }
    } catch (error) {
        console.error('Error saving settings:', error);
        toast.error((error as Error).message || 'Gagal menyimpan pengaturan');
    } finally {
        processing.value = false;
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="General settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall 
                    title="Pengaturan Umum" 
                    description="Kelola informasi dasar perusahaan Anda" 
                />

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Company Name -->
                    <div class="grid gap-2">
                        <Label for="company_name">Nama Perusahaan *</Label>
                        <Input
                            id="company_name"
                            v-model="form.company_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            placeholder="Masukkan nama perusahaan"
                        />
                        <InputError :message="errors.company_name?.[0]" class="mt-2" />
                    </div>

                    <!-- Company Address -->
                    <div class="grid gap-2">
                        <Label for="company_address">Alamat Perusahaan *</Label>
                        <Textarea
                            id="company_address"
                            v-model="form.company_address"
                            class="mt-1 block w-full"
                            rows="3"
                            required
                            placeholder="Masukkan alamat lengkap perusahaan"
                        />
                        <InputError :message="errors.company_address?.[0]" class="mt-2" />
                    </div>

                    <!-- Company Leader -->
                    <div class="grid gap-2">
                        <Label for="company_leader">Nama Pimpinan *</Label>
                        <Input
                            id="company_leader"
                            v-model="form.company_leader"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            placeholder="Masukkan nama pimpinan perusahaan"
                        />
                        <InputError :message="errors.company_leader?.[0]" class="mt-2" />
                    </div>

                    <!-- Company Phone -->
                    <div class="grid gap-2">
                        <Label for="company_phone">Nomor Telepon</Label>
                        <Input
                            id="company_phone"
                            v-model="form.company_phone"
                            type="tel"
                            class="mt-1 block w-full"
                            placeholder="Masukkan nomor telepon perusahaan"
                        />
                        <InputError :message="errors.company_phone?.[0]" class="mt-2" />
                    </div>

                    <!-- Company Email -->
                    <div class="grid gap-2">
                        <Label for="company_email">Email Perusahaan</Label>
                        <Input
                            id="company_email"
                            v-model="form.company_email"
                            type="email"
                            class="mt-1 block w-full"
                            placeholder="Masukkan email perusahaan"
                        />
                        <InputError :message="errors.company_email?.[0]" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4">
                        <Button 
                            type="submit" 
                            :disabled="processing"
                            class="bg-primary hover:bg-primary/90"
                        >
                            {{ processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="recentlySuccessful" class="text-sm text-green-600">
                                Pengaturan berhasil disimpan.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>