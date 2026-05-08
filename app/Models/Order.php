<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'address_id',
        'order_number',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'notes',
        'expires_at',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
        'expires_at'    => 'datetime',
    ];

    // Auto-generate order number
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    // Status helpers
    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isPaid(): bool       { return $this->status === 'paid'; }
    public function isCompleted(): bool  { return $this->status === 'completed'; }
    public function isCancelled(): bool  { return $this->status === 'cancelled'; }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}