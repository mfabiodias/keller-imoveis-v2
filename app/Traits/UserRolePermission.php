<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait UserRolePermission {
    
    private $queryAttributes;
    private $queryConditions = ['<','>','>=','<=','=','!=','<>','like'];

    public function setQueryAttributes($model) 
    {
        $this->queryAttributes = Schema::getColumnListing($model->getTable());
    }

    public function checkTypes($check) 
    {
        if(is_array($check)) {
            return in_array($this->type, $check);
        } else {
            return $this->type == $check;
        }
    }

    public function autoDelete() 
    {
        return auth()->user()->id == $this->id;
    }

    public function autoDisable($data) 
    {
        return auth()->user()->id == $this->id && isset($data['enable']) && $data['enable'] == 0;
    }

    public function blockOwnerAssignment() 
    {
        return $this->type == 'owner';
    }

    public function queryPaginate() 
    {
        $qty = 10;
        $req = request()->query();
        
        if(array_key_exists('qty', $req)) {
            $qty = preg_replace("/[^0-9]/", "", $req['qty']);
        }

        return (int) $qty > 100 ? 10 : $qty;
    }

    public function queryWhere() 
    {
        $rtn = [];
        $req = request()->query();

        if(array_key_exists('where', $req) && !empty($req['where'])) {
            # Separa as colunas
            $parts = explode(",", $req['where']);

            foreach($parts as $part) {
                # Separa coluna da ordenação
                $exp = explode(":", $part);

                # Armazena em um array opções de filtros
                if(in_array($exp[0], $this->queryAttributes) && in_array($exp[1], $this->queryConditions) && count($exp) == 3) {
                    $exp[1] == 'like' ? $exp[2] = str_replace("$", "%", $exp[2]) : false;
                    array_push($rtn, [ $exp[0], $exp[1], $exp[2] ]);
                }
            }
        }

        return $rtn;
    }

    public function queryOrderBy() 
    {
        $rtn = [];
        $req = request()->query();

        if(array_key_exists('orderby', $req) && !empty($req['orderby'])) {
            # Separa as colunas
            $parts = explode(",", $req['orderby']);

            foreach($parts as $part) {
                # Separa coluna da ordenação
                $exp = explode(":", $part);

                # Armazena em um array opções de ordenação
                if(in_array($exp[0], $this->queryAttributes)) {
                    array_push($rtn, [
                        $exp[0],
                        isset($exp[1]) && $exp[1] == 'desc' ? "desc" : "asc",
                    ]);
                }
            }
        }

        return $rtn;
    }

    public function queryTrash() 
    {
        $req = request()->query();

        if(array_key_exists('withTrashed', $req)) {
            if($req['withTrashed'] == "restore") {
                return "withTrashed-restore";
            } else {
                return "withTrashed";
            }
        } else if(array_key_exists('onlyTrashed', $req)) {
            if($req['onlyTrashed'] == "restore") {
                return "onlyTrashed-restore";
            } else {
                return "onlyTrashed";
            }
        } else {
            return false;
        }
    }
}