<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'totalProduk' => 0,
            'totalPenjual' => 0,
            'namaAplikasi' => 'Toko Online',
            'tahun' => (int) date('Y'),
            'versiLaravel' => app()->version(),
        ]);
    }

    public function tentang(): Response
    {
    return Inertia::render('Tentang', [
        'judul' => 'Tentang Kami',
        'deskripsi' => 'Toko Online adalah platform jual beli terpercaya untuk semua kebutuhan Anda.',
        'fitur' => [
            'Belanja mudah dan aman',
            'Ribuan produk pilihan',
            'Pengiriman ke seluruh Indonesia',
        ],
    ]);
    }
}