<?php
 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clientes';

    protected $fillable = ['nome', 'email', 'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // ajuste o nome do model conforme seu sistema
    }

    public function cartItemsCount()
    {
        return $this->cartItems()->count();
    }

    

    public function endereco()
    {
        return $this->hasOne(\App\Models\EnderecoCliente::class, 'cliente_id');
    }

}