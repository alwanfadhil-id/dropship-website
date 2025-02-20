<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'orders';
    protected $fillable = [
        'user_id',
        'products',
        'total_price',
        'status'
    ];
}
