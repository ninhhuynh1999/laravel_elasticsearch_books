<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name',
        'sex',
        'email',
        'phone_number',
        'sales_order_information',
        'address',
        'type',
        'note',
        'is_active',
        'tags',
        'user_id',
    ];
}
