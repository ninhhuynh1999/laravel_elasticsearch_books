<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
        'text',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function books() 
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
