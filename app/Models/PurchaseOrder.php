<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'purchase_order_id';

    protected $fillable = [
        'supplier_id',
        'items',
        'sub_total',
        'tax',
        'discount_items',
        'discount_rate',
        'discount_value',
        'discount_amount',
        'total_amount',
        'payment_details',
        'status',
        'note',
        'tags',
    ];
}
