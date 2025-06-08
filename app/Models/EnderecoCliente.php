<?php   

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnderecoCliente extends Model
{
    protected $table = 'enderecos_clientes'; // Corrige o nome da tabela

    protected $fillable = ['cliente_id', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'cep'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}