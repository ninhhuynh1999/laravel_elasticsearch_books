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
        'gender',
        'email',
        'phone_number',
        'address',
        'note',
        'is_active',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
