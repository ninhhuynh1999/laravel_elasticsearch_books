<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'promotion_id';

    protected $fillable = [
        'name',
        'type',
        'type_name',
        'apply_to_quantity',
        'used_quantity',
        'remain_quantity',
        'apply_from_amount',
        'apply_to_amount',
        'discount_rate',
        'discount_value',
        'start_at',
        'close_at',
        'is_active',
        'status',
        'user_id',
    ];
}
