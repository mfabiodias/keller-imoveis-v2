<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permuta extends Model
{
    use HasFactory;

    protected $table      = "permutas";
    protected $primaryKey = "id";
    protected $fillable   = ['imovel_id', 'tipo_id', 'subtipo_id', 'range_id', 'status'];

    public function imovel()
    {
        return $this->belongsTo("App\Models\Imovel");
    }

    public function range()
    {
        return $this->belongsTo("App\Models\Range");
    }

    public function tipo()
    {
        return $this->belongsTo("App\Models\Tipo");
    }

    public function subtipo()
    {
        return $this->belongsTo("App\Models\Subtipo");
    }
}
