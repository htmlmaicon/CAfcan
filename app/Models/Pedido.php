<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'cliente_id','nome', 'telefone', 'tipo_entrega', 'endereco', 'produtos', 'pagamento'
    ];

    protected $casts = [
        'produtos' => 'array',
    ];
}