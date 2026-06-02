<?php 
namespace App\Http\Controllers; 
  
use App\Models\Category; 
use App\Models\Product; 
use Illuminate\Http\Request; 
use Inertia\Inertia; 
use Inertia\Response; 
  
class ProductController extends Controller 
{ 
    // ─── INDEX: Katalog produk publik ────────────────────────────── 
    public function index(Request $request): Response 
    { 
        $query = Product::where('status', 'active') 
                        ->with(['categories', 'seller']) 
                        ->withCount('reviews'); 
  
        // Filter berdasarkan slug kategori 
        if ($request->category) { 
            $query->whereHas('categories', function ($q) use ($request) { 
                $q->where('slug', $request->category); 
            }); 
        } 
  
        // Pencarian nama produk 
        if ($request->search) { 
            $query->where('name', 'like', '%' . $request->search . '%'); 
        } 
  
        return Inertia::render('Products/Index', [ 
            // withQueryString() menjaga ?search=...&category=... di link pagination 
            'products'   => $query->latest()->paginate(12)->withQueryString(), 
            'categories' => Category::where('is_active', true) 
                                    ->orderBy('sort_order')->get(), 
            // Kirim kembali filter aktif ke Vue 
            'filters'    => $request->only('search', 'category'), 
        ]); 
    } 
  
    // ─── SHOW: Detail produk ──────────────────────────────────────── 
    public function show(Product $product): Response 
    { 
        // Increment views setiap halaman detail dibuka 
        $product->increment('views'); 
  
        // Load semua relasi yang dibutuhkan  
        $product->load([ 
            'categories', 
            'seller', 
            'reviews' => fn($q) => $q->with('user:id,name,avatar')->latest(), 
        ]); 
  
        return Inertia::render('Products/Show', [ 
            'product'    => $product, 
            'produkLain' => Product::where('user_id', $product->user_id) 
                                   ->where('id', '!=', $product->id) 
                                   ->where('status', 'active') 
                                   ->take(4)->get(), 
        ]); 
    } 
}