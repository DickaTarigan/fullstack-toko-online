<?php 
namespace App\Http\Controllers; 
  
use App\Models\Order; 
use Illuminate\Http\Request; 
use Inertia\Inertia; 
use Inertia\Response; 
  
class OrderController extends Controller 
{ 
    // ─── dashboard(): Halaman Dashboard Buyer ─────────────────────
    public function dashboard(Request $request): Response
    {
        // Sesuaikan 'Dashboard' dengan lokasi file Vue kamu
        // Misalnya jika ada di folder resources/js/Pages/Dashboard.vue
        return Inertia::render('Dashboard'); 
    }

    // ─── index(): Daftar pesanan buyer ──────────────────────────── 
    public function index(Request $request): Response 
    { 
        $orders = Order::where('user_id', $request->user()->id) 
                        ->with('items') // eager load untuk hitung jumlah item 
                        ->latest() 
                        ->paginate(10); 
                        
        return Inertia::render('Orders/Index', compact('orders')); 
    } 

    // ─── show(): Detail satu pesanan ────────────────────────────── 
    public function show(Request $request, Order $order): Response 
    { 
        // Pastikan order ini milik buyer yang sedang login 
        abort_if($order->user_id !== $request->user()->id, 403, 'Bukan pesanan Anda.'); 
        
        // Load semua relasi yang dibutuhkan halaman detail 
        $order->load(['items.product', 'buyer']); 
        
        return Inertia::render('Orders/Show', compact('order')); 
    }
}