<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'return_order_id';

    protected $fillable = [
        'sales_order_id',
        'customer_id',
        'user_id',
        'items',
        'total_item',
        'total_quantity',
        'total_amount',
        'note',
    ];
}
