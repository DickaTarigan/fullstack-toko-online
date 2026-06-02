<script setup> 
import AppLayout from '@/Layouts/AppLayout.vue'; 
import { Link, Head, router } from '@inertiajs/vue3'; 
import { ref, watch } from 'vue'; 
  
const props = defineProps({ 
    products:   Object, 
    categories: Array, 
    filters:    Object, 
}); 
  
// Inisialisasi dari filter yang sudah aktif (dari URL) 
const search   = ref(props.filters.search   || ''); 
const category = ref(props.filters.category || ''); 
  
// Kirim filter ke server 
const applyFilters = () => { 
    router.get(route('products.index'), { 
        search:   search.value   || undefined, 
        category: category.value || undefined, 
    }, { preserveState: true }); 
}; 
  
// Auto-apply saat kategori chip diklik 
watch(category, applyFilters); 
  
// Format Rupiah 
const rupiah = (n) => new Intl.NumberFormat('id-ID', { 
    style: 'currency', currency: 'IDR', maximumFractionDigits: 0 
}).format(n); 
</script> 
  
<template> 
    <AppLayout> 
        <Head title="Katalog Produk" /> 
        <div class="max-w-7xl mx-auto px-4 py-8"> 
  
            <!-- Header --> 
            <div class="mb-6"> 
                <h1 class="text-3xl font-bold">Katalog Produk</h1> 
                <p class="text-gray-500 mt-1"> 
                    {{ products.total }} produk ditemukan 
                </p> 
            </div> 
  
            <!-- Search Bar --> 
            <form @submit.prevent="applyFilters" class="flex gap-2 mb-6"> 
                <input v-model="search" type="text" class="input flex-1" 
                       placeholder="🔍 Cari produk..." /> 
                <button type="submit" class="btn-primary">Cari</button> 
                <button v-if="search || category" type="button" 
                        @click="search=''; category=''; applyFilters()" 
                        class="btn-secondary"> 
                    Reset 
                </button> 
            </form> 

            <!-- Filter Kategori (chip) --> 
            <div class="flex gap-2 flex-wrap mb-8"> 
                <button @click="category = ''" 
                        :class="!category 
                            ? 'bg-indigo-600 text-white border-indigo-600' 
                            : 'bg-white text-gray-700 border-gray-300'" 
                        class="px-4 py-1.5 rounded-full border text-sm font-medium 
                               transition-colors"> 
                    Semua 
                </button> 
                <button v-for="cat in categories" :key="cat.id" 
                        @click="category = cat.slug" 
                        :class="category === cat.slug 
                            ? 'bg-indigo-600 text-white border-indigo-600' 
                            : 'bg-white text-gray-700 border-gray-300'" 
                        class="px-4 py-1.5 rounded-full border text-sm transition-colors"> 
                    {{ cat.icon }} {{ cat.name }} 
                </button> 
            </div> 
  
            <!-- Grid Produk --> 
            <div v-if="products.data.length > 0" 
                 class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap4"> 
                <Link v-for="prod in products.data" :key="prod.id" 
                      :href="route('products.show', prod.slug)" 
                      class="card hover:shadow-lg transition-shadow group"> 
                    <div class="w-full h-48 rounded-lg overflow-hidden mb3"> 
                        <img :src="prod.image ? '/storage/'+prod.image : '/img/no-image.png'" 
                             class="w-full h-full object-cover grouphover:scale-105 
                                    transition-transform duration-300" /> 
                    </div> 
                    <h3 class="font-semibold text-sm line-clamp-2 mb-1">{{ prod.name }}</h3> 
                    <p class="text-indigo-600 font-bold">{{ rupiah(prod.price) }}</p> 
                    <p class="text-xs text-gray-400 mt-1"> 
                        Stok: {{ prod.stock }}  ·  {{ prod.reviews_count }} ulasan 
                    </p> 
                </Link> 
            </div> 
  
            <!-- Kosong --> 
            <div v-else class="text-center py-20 text-gray-400"> 
                <p class="text-5xl mb-4">😔</p> 
                <p class="text-lg">Produk tidak ditemukan.</p> 
                <p class="text-sm">Coba ubah filter atau kata pencarian.</p> 
            </div> 
  
            <!-- Pagination --> 
            <div class="mt-10 flex gap-2 justify-center flex-wrap"> 
                <Link v-for="link in products.links" :key="link.label" 
                      :href="link.url || '#'" 
                      v-html="link.label" 
                      :class="[ 
                          link.active ? 'bg-indigo-600 text-white borderindigo-600' : 'bg-white text-gray-700', 
                          link.url ? '' : 'opacity-50 cursor-not-allowed', 
                          'px-4 py-2 border rounded-lg text-sm transitioncolors', 
                      ]" /> 
            </div> 
        </div> 
    </AppLayout> 
</template> 