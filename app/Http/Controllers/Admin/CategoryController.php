<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    // ─── INDEX: Daftar semua kategori ──────────────────────────────
   public function index(Request $request): Response
{
    $categories = Category::when(
            $request->status === 'active',
            fn($q) => $q->where('is_active', true)
        )
        ->when(
            $request->status === 'inactive',
            fn($q) => $q->where('is_active', false)
        )
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(15)
        ->withQueryString();

    return Inertia::render('Admin/Categories/Index', [
        'categories' => $categories,
        'filters' => $request->only('status'), // ← kirim filter ke Vue
    ]);
}

    // ─── CREATE: Tampilkan form tambah ──────────────────────────────
    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Create');
    }

    // ─── STORE: Simpan kategori baru ────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // ─── EDIT: Tampilkan form edit ──────────────────────────────────
    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    // ─── UPDATE: Simpan perubahan ───────────────────────────────────
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            if ($category->products()->count() > 0) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
            }
        } catch (\Exception $e) {
            // Tabel products belum ada, lanjut hapus
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
        // ─── TOGGLE: Aktif/Nonaktifkan kategori ─────────────────────────────
    public function toggle(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil {$status}.");
    }
}