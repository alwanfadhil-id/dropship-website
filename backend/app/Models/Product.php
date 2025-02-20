<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        '
        images'
    ];
}
