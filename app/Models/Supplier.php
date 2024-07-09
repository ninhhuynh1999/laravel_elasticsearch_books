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
        'contact',
        'address',
        'description',
        'is_active',
        'user_id',
    ];
}
