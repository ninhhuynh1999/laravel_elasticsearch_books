<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'barcode',
        'sku',
        'name',
        'current_stock',
        'min_stock',
        'max_stock',
        'description',
        'sale_price',
        'purchase_price',
        'details',
        'optional_details',
        'is_active',
        'status',
        'images',
        'tags',
        'user_id',
    ];
}
