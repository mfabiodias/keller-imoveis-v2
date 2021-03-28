<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table      = "enderecos";
    protected $primaryKey = "id";
    protected $fillable   = [
        'cliente_id', 'imovel_id', 'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado'
    ];

    public function rel()
    {
        return $this->morphTo();
    }

    // public function cliente()
    // {
    //     return $this->morphedByMany(Cliente::class, 'endereco', 'endereco_relacionamentos');
    // }
    
    // public function imovel()
    // {
    //     return $this->morphedByMany(Imovel::class, 'endereco', 'endereco_relacionamentos');
    // }
}
