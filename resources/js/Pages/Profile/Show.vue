<script setup>
defineProps({ user: Object });
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <div class="card max-w-md w-full">
            <div class="text-center mb-6">
                <p class="text-5xl mb-3">👤</p>
                <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase">Nama</p>
                    <p class="text-gray-800 font-semibold mt-1">{{ user?.name }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase">Email</p>
                    <p class="text-gray-800 font-semibold mt-1">{{ user?.email }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase">Role</p>
                    <p class="text-gray-800 font-semibold mt-1 capitalize">{{ user?.role }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase">Nomor Telepon</p>
                    <p class="text-gray-800 font-semibold mt-1">{{ user?.phone ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="/dashboard" class="btn-primary">← Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</template>