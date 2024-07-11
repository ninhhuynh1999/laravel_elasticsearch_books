<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'name',
        'email',
        'address',
        'description',
        'is_active',
        'user_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
