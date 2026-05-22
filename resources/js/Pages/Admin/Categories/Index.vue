<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    categories: Object,
    filters: Object,
});

const statusFilter = ref(props.filters?.status ?? '');

const hapus = (id) => {
    if (confirm('Yakin ingin menghapus kategori ini?')) {
        router.delete(route('admin.categories.destroy', id));
    }
};

const toggle = (id) => {
    router.post(route('admin.categories.toggle', id));
};

const filterStatus = () => {
    router.get(route('admin.categories.index'),
        { status: statusFilter.value },
        { preserveScroll: true }
    );
};
</script>

<template>
    <AppLayout>
        <Head title="Kelola Kategori" />
        <div class="max-w-5xl mx-auto px-4 py-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Kategori</h1>

                <div class="flex items-center gap-3">
                    <select v-model="statusFilter" @change="filterStatus"
                        class="text-sm border border-gray-300 rounded-lg px-3 py-2
                               focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>

                    <Link :href="route('admin.categories.create')" class="btn-primary">
                        + Tambah Kategori
                    </Link>
                </div>
            </div>

            <!-- Tabel -->
            <div class="card overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-teal-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Slug</th>
                            <th class="px-4 py-3 text-center">Urutan</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cat in categories.data" :key="cat.id"
                            class="border-b hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-medium">
                                {{ cat.icon }} {{ cat.name }}
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-500">
                                {{ cat.slug }}
                            </td>
                            <td class="px-4 py-3 text-center">{{ cat.sort_order }}</td>
                            <td class="px-4 py-3 text-center">
                                <span :class="cat.is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-500'"
                                    class="px-2 py-1 rounded-full text-xs font-medium">
                                    {{ cat.is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <Link :href="route('admin.categories.edit', cat.id)"
                                    class="text-blue-600 hover:underline text-xs">
                                    Edit
                                </Link>

                                <button @click="toggle(cat.id)"
                                    class="text-xs hover:underline"
                                    :class="cat.is_active ? 'text-yellow-600' : 'text-green-600'">
                                    {{ cat.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>

                                <button @click="hapus(cat.id)"
                                    class="text-red-600 hover:underline text-xs">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                Belum ada kategori. Klik '+ Tambah Kategori'.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex gap-2">
                <Link v-for="link in categories.links" :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    :class="[link.active ? 'bg-teal-600 text-white' : 'bg-white text-gray-700',
                             'px-3 py-1 border rounded text-sm']" />
            </div>

        </div>
    </AppLayout>
</template>