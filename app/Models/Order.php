<?php 
namespace App\Models; 
  
use Illuminate\Database\Eloquent\Model; 
  
class Order extends Model 
{ 
    // ─── Konstanta Status — mencegah typo ───────────────────────── 
    const STATUS_PENDING    = 'pending'; 
    const STATUS_PAID       = 'paid'; 
    const STATUS_PROCESSING = 'processing'; 
    const STATUS_SHIPPED    = 'shipped'; 
    const STATUS_DELIVERED  = 'delivered'; 
    const STATUS_CANCELLED  = 'cancelled'; 
  
    protected $fillable = [ 
        'user_id', 'order_number', 'status', 'total_amount', 
        'shipping_address', 'phone', 'notes', 
        'payment_proof', 'paid_at', 'shipped_at', 'delivered_at', 
    ]; 
  
    protected $casts = [ 
        'total_amount'  => 'decimal:2', 
        'paid_at'       => 'datetime', 
        'shipped_at'    => 'datetime', 
        'delivered_at'  => 'datetime', 
    ]; 
  
    // ─── Relasi ──────────────────────────────────────────────────── 
    public function buyer() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    } 
  
    public function items() 
    { 
        return $this->hasMany(OrderItem::class); 
    } 

    // ─── Generate nomor order unik ───────────────────────────────── 
    public static function generateNumber(): string 
    { 
        $count = static::whereDate('created_at', today())->count() + 1; 
        return 'INV-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT); 
        // Contoh: INV-20240115-0001 
    } 
} 