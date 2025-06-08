<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'product_id',
        'quantity',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


