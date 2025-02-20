<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property mixed $products
 */
class Cart extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'carts';
    protected $fillable = ['user_id', 'products'];
}
