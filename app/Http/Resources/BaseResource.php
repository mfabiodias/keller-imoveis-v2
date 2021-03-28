<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public $resource;
    public $query_url;
    public $query_src;
    public $query_all;
    public $query_col;
    public $query_rel;
    public $query_rtn;
    public $rel_class;

    public function __construct($resource, $query_src=[])
    {
        $this->resource  = $resource;
        $this->query_src = $query_src;
        $this->query_rel = [];
        $this->query_col = [];
        $this->rel_class = [];
    }

    public function setDefaultResource(array $rtn)
    {
        $this->query_rtn = $rtn;
    }

    public function setRelationshipResource(array $rel)
    {
        $this->rel_class = $rel;
    }

    public function toArray($request)
    {
        # Coleta parametros da URL para adicionar dados de relacionamentos
        $this->query_url = $request->query();

        # Parametros para mostrar todas colunas 
        $this->query_all = array_key_exists('all', $this->query_url);
        
        # Parametros para mostrar colunas especificadas
        if(is_array($this->query_url) && isset($this->query_url['col'])) {
            $columns = explode(",", $this->query_url['col']);
            $this->query_col = $this->getArrayableItemsCol($columns);
        }

        # Armazena relacionamentos
        if(is_array($this->query_url) && isset($this->query_url['rel'])) {
            $this->query_rel = explode(",", $this->query_url['rel']);
        }

        # Mescla relacionamentos de parametros com outros parametros passados na instancia da classe
        if(is_array($this->query_src)) {
            $this->query_rel = array_unique(array_merge($this->query_rel, $this->query_src), SORT_REGULAR);
        }

        if(is_null($this->resource)) {
            return '';
        } else {
            if(!empty($this->query_col)) {
                $rtn = $this->query_col;
            } else if($this->query_all) {
                $rtn = $this->getArrayableItems();
            } else {
                $rtn = $this->query_rtn;
            }

            # Verifica valores de relacionamento para adicionar a consulta
            if(is_array($this->query_rel) && !empty($this->query_rel)) {
                foreach($this->query_rel as $relationship) {
                    if(isset($this->{$relationship})) {
                        if(isset($this->rel_class[$relationship])) {
                            if($this->{$relationship} instanceof Collection) {
                                $rtn[$relationship] = $this->query_all ? $this->{$relationship} : $this->rel_class[$relationship]::collection($this->{$relationship});
                            } else {
                                $rtn[$relationship] = $this->query_all ? $this->{$relationship} : new $this->rel_class[$relationship]($this->{$relationship});
                            }
                        } else {
                            $rtn[$relationship] = $this->{$relationship};
                        }
                    }
                }
            }

            return $rtn;
        }
    }

    private function getArrayableItems()
    {
        $values = $this->getAttributes();
        
        if (count($this->getVisible()) > 0) {
            $values = array_intersect_key($this->getAttributes(), array_flip($this->getVisible()));
        }

        if (count($this->getHidden()) > 0) {
            $values = array_diff_key($this->getAttributes(), array_flip($this->getHidden()));
        }

        return $values;
    }

    private function getArrayableItemsCol(array $values)
    {
        return array_intersect_key($this->getAttributes(), array_flip($values));
    }
}
