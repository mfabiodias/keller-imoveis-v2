<?php

namespace App\Http\Resources\Cliente;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteEnderecosResource extends JsonResource
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
            'id'          => $this->id,
            'cep'         => $this->cep,
            'rua'         => $this->rua,
            'numero'      => $this->numero,
            'complemento' => $this->complemento,
            'bairro'      => $this->bairro,
            'cidade'      => $this->cidade,
            'estado'      => $this->estado,
        ];
    }
}