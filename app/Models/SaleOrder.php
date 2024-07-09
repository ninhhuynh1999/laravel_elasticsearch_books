<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'sale_order_id';

    protected $fillable = [
        'return_date',
        'customer_type',
        'customer_id',
        'items',
        'subtotal',
        'discount_items',
        'discount_rate',
        'discount_value',
        'discount_amount',
        'tax',
        'total_amount',
        'payment_details',
        'status',
        'note',
        'user_id',
    ];
}
