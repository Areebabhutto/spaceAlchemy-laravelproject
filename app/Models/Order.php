<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'total_amount',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad(self::count() + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get status label with color
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => ['label' => 'Pending', 'color' => 'warning'],
            'processing' => ['label' => 'Processing', 'color' => 'info'],
            'shipped' => ['label' => 'Shipped', 'color' => 'primary'],
            'delivered' => ['label' => 'Delivered', 'color' => 'success'],
            'cancelled' => ['label' => 'Cancelled', 'color' => 'danger'],
            default => ['label' => 'Unknown', 'color' => 'secondary'],
        };
    }
}
