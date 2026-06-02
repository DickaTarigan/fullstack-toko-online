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
        Schema::create('orders', function (Blueprint $table) { 
            $table->id(); 
            $table->foreignId('user_id')           // buyer pemilik pesanan 
                ->constrained()->onDelete('cascade'); 
            $table->string('order_number')->unique(); // contoh: INV-20240115-0001 
            $table->enum('status', [ 
                'pending',      // baru dibuat, menunggu pembayaran 
                'paid',         // bukti bayar sudah diupload 
                'processing',   // seller konfirmasi, sedang dikemas 
                'shipped',      // paket sudah dikirim 
                'delivered',    // buyer konfirmasi terima 
                'cancelled',    // dibatalkan 
            ])->default('pending'); 
            $table->decimal('total_amount', 14, 2); 
            $table->text('shipping_address'); 
            $table->string('phone', 20); 
            $table->text('notes')->nullable(); 
            $table->string('payment_proof')->nullable(); // path foto bukti bayar 
            $table->timestamp('paid_at')->nullable(); 
            $table->timestamp('shipped_at')->nullable(); 
            $table->timestamp('delivered_at')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
