<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'gross_amount',
        'snap_token',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
