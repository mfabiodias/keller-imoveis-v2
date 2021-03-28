<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Imovel;

class TestController extends Controller
{
    public function index($id)
    {

        $cliente = Cliente::find($id);
        $imovel  = Imovel::find($id);

        dump($cliente->enderecos->toArray());
        dump($imovel->enderecos->toArray());

        // return response()->json(['message' => 'Update JSON OK'], 201);
    }
}