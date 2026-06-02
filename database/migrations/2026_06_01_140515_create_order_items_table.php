<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) { 
            $table->id(); 
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); 
            // ─── SNAPSHOT — nilai ini tidak berubah meski produk diupdate ─── 
            $table->string('product_name');          // nama produk saat checkout 
            $table->decimal('price', 12, 2);         // harga produk saat checkout 
            $table->unsignedInteger('qty');          // jumlah yang dibeli 
            $table->string('product_image')->nullable(); // foto saat checkout 
            // subtotal = price × qty (dihitung di aplikasi, tidak disimpan) 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
