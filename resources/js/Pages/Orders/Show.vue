<script setup> 
import AppLayout from '@/Layouts/AppLayout.vue'; 
import { Link, Head } from '@inertiajs/vue3'; 
import { computed } from 'vue'; 
  
const props = defineProps({ order: Object }); 
  
const rupiah = (n) => new Intl.NumberFormat('id-ID', { 
    style: 'currency', currency: 'IDR', maximumFractionDigits: 0 
}).format(n); 
  
const statusClass = computed(() => ({ 
    pending:    'bg-yellow-100 text-yellow-700', 
    paid:       'bg-blue-100 text-blue-700', 
    processing: 'bg-purple-100 text-purple-700', 
    shipped:    'bg-teal-100 text-teal-700', 
    delivered:  'bg-green-100 text-green-700', 
    cancelled:  'bg-red-100 text-red-700', 
}[props.order.status])); 
</script> 
  
<template> 
    <AppLayout> 
        <Head :title="order.order_number" /> 
        <div class="max-w-3xl mx-auto px-4 py-8"> 
  
            <!-- Header --> 
            <div class="flex justify-between items-center mb-6"> 
                <div> 
                    <Link href="/orders" class="text-gray-400 hover:textgray-600 text-sm"> 
                        ← Kembali ke Pesanan 
                    </Link> 
                    <h1 class="text-xl font-bold font-mono mt-1">{{ order.order_number }}</h1> 
                </div> 
                <span :class="[statusClass, 'px-4 py-2 rounded-full fontmedium']"> 
                    {{ order.status }} 
                </span> 
            </div> 
  
            <!-- Tabel Item --> 
            <div class="card mb-6"> 
                <h2 class="font-bold mb-4">📦 Item Pesanan</h2> 
                <table class="w-full text-sm"> 
                    <thead class="bg-gray-50"> 
                        <tr> 
                            <th class="px-3 py-2 text-left">Produk</th> 
                            <th class="px-3 py-2 text-right">Harga</th> 
                            <th class="px-3 py-2 text-center">Qty</th> 
                            <th class="px-3 py-2 text-right">Subtotal</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        <tr v-for="item in order.items" :key="item.id" 
                            class="border-b"> 
                            <td class="px-3 py-3"> 
                                <div class="flex items-center gap-3"> 
                                    <img :src="item.product_image 
                                               ? '/storage/'+item.product_image 
                                               : '/img/no-image.png'" 
                                         class="w-10 h-10 object-cover rounded" /> 
                                    <!-- product_name adalah SNAPSHOT ─ tidak berubah --> 
                                    <span>{{ item.product_name }}</span> 
                                </div> 
                            </td> 
                            <!-- price adalah SNAPSHOT ─ harga saat checkout --> 
                            <td class="px-3 py-3 text-right">{{ rupiah(item.price) }}</td> 
                            <td class="px-3 py-3 text-center">{{ item.qty }}</td> 
                            <td class="px-3 py-3 text-right font-bold"> 
                                {{ rupiah(item.price * item.qty) }} 
                            </td> 
                        </tr> 
                    </tbody> 
                    <tfoot> 
                        <tr class="bg-gray-50"> 
                            <td colspan="3" class="px-3 py-3 font-bold text-right">Total</td> 
                            <td class="px-3 py-3 text-right font-bold textteal-700 text-lg"> 
                                {{ rupiah(order.total_amount) }} 
                            </td> 
                        </tr> 
                    </tfoot> 
                </table> 
            </div> 
  
            <!-- Info Pengiriman --> 
            <div class="card mb-6"> 
                <h2 class="font-bold mb-4">📍 Informasi Pengiriman</h2> 
                <p class="text-gray-700">{{ order.shipping_address }}</p> 
                <p class="text-gray-500 text-sm mt-1">📞 {{ order.phone }}</p> 
                <p v-if="order.notes" class="text-gray-500 text-sm mt-1"> 
                    📝 {{ order.notes }} 
                </p> 
            </div> 
  
            <!-- Tombol Upload Bayar (hanya jika pending) --> 
            <!-- Akan diimplementasi di P9 --> 
            <div v-if="order.status === 'pending'" 
                 class="card bg-yellow-50 border-yellow-200 text-center"> 
                <p class="text-yellow-700 font-medium"> 
                    💳 Upload bukti pembayaran akan tersedia di Pertemuan 9 
                </p> 
            </div> 
        </div> 
    </AppLayout> 
</template> 