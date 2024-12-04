<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_name',
        'price',
        'quantity',
        'total_price'
    ];

    /**
     * Define the relationship with Cart.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
