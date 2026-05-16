<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'car_id', 
        'tanggal_sewa', 
        'tanggal_kembali', 
        'total_harga', 
        'status'
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}