<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteUpsertRequest;
use App\Http\Resources\Cliente\{ 
    ClienteCollection, ClienteResource 
};
use App\Models\Cliente;

class ClienteController extends Controller
{
    private $context;

    public function __construct()
    {
        $this->context = "Cliente";
    }


    // public function show(Event $event)
    // {
    //     return Inertia::render('Event/Show', [
    //         'event' => $event->only(
    //             'id',
    //             'title',
    //             'start_date',
    //             'description'
    //         ),
    //     ]);
    // }


    public function index()
    {
        # Obtem um novo construtor de consulta
        $model = new Cliente;
        
        # Envia classe para armazenar attributes
        auth()->user()->setQueryAttributes($model);
        
        # Obtem um novo construtor de consulta
        $query = $model->newQuery();

        # Verifica se existem as colunas recebidas para aplicar filtros na consulta
        $whereData = auth()->user()->queryWhere();

        # Apresenta consulta com dados ordenados
        if(!empty($whereData)) {
            foreach($whereData as $where) {
                if(count($where) == 3) {
                    $query->where($where[0], $where[1], $where[2]);
                } else {
                    $query->where($where[0], $where[1]);
                }
            }
        }

        # Verifica se existem as colunas recebidas para aplicar ordenação na consultar
        $orderByData = auth()->user()->queryOrderBy();
        
        # Apresenta consulta com dados ordenados
        if(!empty($orderByData)) {
            foreach($orderByData as $orderBy) {
                $query->orderBy($orderBy[0], $orderBy[1]);
            }
        }
        
        return new ClienteCollection($query->paginate(auth()->user()->queryPaginate()));
    }

    public function store(ClienteUpsertRequest $request)
    {
        $data = $request->only([ 
            'nome', 'email', 'tel_residencial', 'tel_comercial', 'cel', 'cel_operadora', 
            'nextel_id', 'nacionalidade', 'doc_tipo', 'doc_numero', 'perfil', 'fase', 'tipo', 
            'investidor', 'origem'
        ]);
        $data = Cliente::create($data);
        
        $rtn = ['message' => $this->context.' criado com sucesso.', 'data' => $data ];
        $sts = 201;

        return response()->json($rtn, $sts);
    }

    public function show($id)
    {
        $id = preg_replace("/[^0-9]/", "", $id);

        $cliente = Cliente::find($id);

        if(!$cliente) {
            $rtn = [ 'message'=> $this->context.' não encontrado.' ];
            $sts = 404;
        } else {
            $rtn = [ 'message'=> $this->context.' encontrado', 'data' => new ClienteResource($cliente) ];
            $sts = 200;
        }

        return response()->json($rtn, $sts);
    }

    public function update(ClienteUpsertRequest $request, $id)
    {
        $id = preg_replace("/[^0-9]/", "", $id);

        $data = $request->only([ 
            'tel_residencial', 'tel_comercial', 'cel', 'cel_operadora', 'nextel_id', 'nacionalidade', 
            'doc_tipo', 'doc_numero', 'perfil', 'fase', 'tipo', 'investidor', 'origem'
        ]);
        $cliente = Cliente::find($id);

        if(!$cliente) {
            $rtn = [ 'message'=> $this->context.' não encontrado.' ];
            $sts = 404;
        } else {
            $cliente->update($data);
            $rtn = [ 'message'=> $this->context.' atualizado com sucesso.', 'data' => Cliente::find($cliente->id) ];
            $sts = 201;
        }
        
        return response()->json($rtn, $sts);
    }

    public function destroy($id)
    {
        $id = preg_replace("/[^0-9]/", "", $id);
        
        # Bloqueia o acesso de onwer
        if(auth()->user()->checkTypes($this->checkType)) {
            return response()->json(['message' => $this->checkFailMessage], 401);
        }

        # Verifica permissão de acesso
        $method = 'excluír';
        if(!auth()->user()->checkPermission($this->type, $this->page, __FUNCTION__)) {
            return response()->json(['message' => str_replace('{method}', $method, $this->checkFailPermission)], 401);
        }

        $cliente = Cliente::find($id);

        if(!$cliente) {
            return response()->json([
                'message'   => $this->context.' não encontrado.',
            ], 404);
        } else { 
            $enderecoQty = count($cliente->enderecos);
            $imovelQty   = count($cliente->imoveis);

            $rtn = [ 'message' => '', 'data' => new ClienteResource($cliente) ];

            if($enderecoQty > 0) {
                $rtn['message'] = $this->context.' não pode ser excluído! '.$enderecoQty.' endereço(s) vinculado(s)';
                $sts = 403;
            } else if($imovelQty > 0) {
                $rtn['message'] = $this->context.' não pode ser excluído! '.$imovelQty.' imovel(s) vinculado(s)';
                $sts = 403;
            } else {
                $cliente->delete();
                $rtn = [ 'message' => $this->context.' excluído com sucesso.' ];
                $sts = 200;
            }

            return response()->json($rtn, $sts);
        }
    }
}
