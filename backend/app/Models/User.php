<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable; // Gunakan Authenticatable dari MongoDB
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Koneksi database yang digunakan.
     *
     * @var string
     */
    protected $connection = 'mongodb'; // Pastikan menggunakan koneksi MongoDB

    /**
     * Nama collection di database.
     *
     * @var string
     */
    protected $collection = 'users'; // Default collection di MongoDB

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
