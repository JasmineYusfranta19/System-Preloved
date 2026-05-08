<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_code',
        'method',
        'amount',
        'status',
        'midtrans_token',
        'midtrans_redirect_url',
        'gateway_response',
        'paid_at',
        'expires_at',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at'          => 'datetime',
        'expires_at'       => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            $payment->payment_code = 'PAY-' . strtoupper(uniqid());
        });
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Helpers
    public function isPaid(): bool    { return $this->status === 'paid'; }
    public function isPending(): bool { return $this->status === 'pending'; }
    public function isExpired(): bool { return $this->status === 'expired'; }
}