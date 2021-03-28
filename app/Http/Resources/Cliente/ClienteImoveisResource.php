<?php

namespace App\Http\Resources\Cliente;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteImoveisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'nome'      => $this->nome,
            'permuta'   => $this->permuta,
            'status'    => $this->status,
        ];
    }
}