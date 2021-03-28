<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table      = "clientes";
    protected $primaryKey = "id";
    protected $fillable   = [
        'nome', 'email', 'tel_residencial', 'tel_comercial', 'cel', 'cel_operadora', 
        'nextel_id', 'nacionalidade', 'doc_tipo', 'doc_numero', 'perfil', 'fase',
        'tipo', 'investidor', 'origem'
    ];

    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'rel');
    }

    public function imovel()
    {
        return $this->hasMany("App\Models\Imovel");
    }

    public function permunta()
    {
        return $this->hasMany("App\Models\Permuta");
    }
}