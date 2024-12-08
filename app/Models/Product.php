<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'product_name',
        'description',
        'price',
        'quantity',
        'category',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
