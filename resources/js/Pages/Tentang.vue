<script setup>
defineProps({
    judul: String,
    deskripsi: String,
    fitur: Array,
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
            <div class="max-w-7xl mx-auto px-4 py-20 text-center">
                <h1 class="text-5xl font-bold mb-4">{{ judul }}</h1>
                <p class="text-blue-100 text-lg">{{ deskripsi }}</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="card max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    Fitur Unggulan
                </h2>
                <ul class="space-y-4">
                    <li
                        v-for="(item, index) in fitur"
                        :key="index"
                        class="flex items-center gap-3 text-gray-700"
                    >
                        <span class="text-green-500 font-bold">✓</span>
                        {{ item }}
                    </li>
                </ul>
            </div>

            <div class="text-center mt-8">
                <a href="/" class="btn-primary">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</template>