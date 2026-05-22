<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ user: Object });
</script>

<template>
    <AppLayout>
        <Head title="Dashboard" />
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="card text-center max-w-md mx-auto">
                <p class="text-4xl mb-4">🛍</p>
                <h1 class="text-2xl font-bold mb-2">
                    Selamat Datang, {{ user?.name }}!
                </h1>
                <p class="text-gray-500">Dashboard Buyer</p>
                <p class="text-xs mt-2 text-blue-600 font-mono">role: buyer ✅</p>
            </div>
        </div>
    </AppLayout>
</template>