<?php

namespace App\Models;

use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory, HasUuids, Searchable;
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'supplier_id',
        'barcode',
        'sku',
        'name',
        'current_stock',
        'min_stock',
        'max_stock',
        'description',
        'sale_price',
        'purchase_price',
        'is_active',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'products';
    }


    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'model');
    }
}
