<?php

namespace App\Http\Resources\Cliente;

use App\Http\Resources\BaseResource;

class ClienteResource extends BaseResource
{
    public function __construct($resource, $query_params=[])
    {
        parent::__construct($resource, $query_params);

        parent::setDefaultResource([ 
            'id'              => $this->id,
            'key'             => $this->id,
            'nome'            => $this->nome,
            'email'           => $this->email,
            // 'tel_residencial' => $this->tel_residencial,
            // 'tel_comercial'   => $this->tel_comercial,
            // 'cel'             => $this->cel,
            // 'cel_operadora'   => $this->cel_operadora,
            // 'nextel_id'       => $this->nextel_id,
            // 'nacionalidade'   => $this->type,
            // 'doc_tipo'        => $this->doc_tipo,
            // 'doc_numero'      => $this->doc_numero,
            // 'perfil'          => $this->perfil,
            // 'fase'            => $this->fase,
            'tipo'            => $this->tipo,
            // 'investidor'      => $this->investidor,
            // 'origem'          => $this->investidor,
            // 'action'           => $this->action,
        ]);

        parent::setRelationshipResource([
            'enderecos' => ClienteEnderecosResource::class,
            'imoveis'   => ClienteImoveisResource::class,
        ]);
    }    
}