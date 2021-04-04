<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nome'            => 'required|max:100',
            'email'           => 'required|email|unique:cliente,email|max:255',
            'tel_residencial' => 'nullable|max:30',
            'tel_comercial'   => 'nullable|max:30',
            'cel'             => 'nullable|max:30',
            'cel_operadora'   => 'nullable|in:Claro,CTBC,OI,Sercomtel,Tim,Vivo,Nextel',
            'nextel_id'       => 'nullable|max:20',
            'nacionalidade'   => 'required|in:Brasileira,Estrangeira',
            'doc_tipo'        => 'required|in:RG,CPF,CNPJ,RNE,CNH,Passaporte,Carteira de Trabalho,Título Eleitor,Certidão Nascimento',
            'doc_numero'      => 'required|max:30',
            'perfil'          => 'required|in:Proprietário,Cliente Interessado',
            'fase'            => 'required|in:Novo,Em Atendimento,Com Proposta,Ganhou,Perdeu,Inativo',
            'tipo'            => 'required|in:Pessoa Física,Pessoa Jurídica',
            'investidor'      => 'required|in:Sim,Não',
            'origem'          => 'required|in:Email,Jornal,Pessoal,Placa,Revista,Site,Telefone,Outros',
        ];
        
        if(parent::method() == 'PUT') {
            unset($rules['nome']);
            unset($rules['email']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nome.required'          => 'Nome é obrigatório.',
            'nome.max'               => 'Nome aceita até :max caracteres.',
            'email.required'         => 'Email é obrigatório.',
            'email.email'            => 'Email inválido.',
            'email.unique'           => 'Email já encontra-se cadastrado.',
            'email.max'              => 'Email aceita até :max caracteres.',
            'tel_residencial.max'    => 'Telefone residencial aceita até :max caracteres.',
            'tel_comercial.max'      => 'Telefone comercial aceita até :max caracteres.',
            'cel.max'                => 'Celular aceita até :max caracteres.',
            'cel_operadora.in'       => 'Operadora celular aceita somente (Claro, CTBC, OI, Sercomtel, Tim, Vivo, Nextel).',
            'nextel_id.max'          => 'ID Nextel aceita até :max caracteres.',
            'nacionalidade.required' => 'Nacionalidade é obrigatória.',
            'nacionalidade.in'       => 'Nacionalidade aceita somente (Brasileira, Estrangeira).',
            'doc_tipo.required'      => 'Tipo de documento é obrigatório.',
            'doc_tipo.in'            => 'Tipo de documento aceita somente (RG, CPF, CNPJ, RNE, CNH, Passaporte, Carteira de Trabalho, Título Eleitor, Certidão Nascimento).',
            'doc_numero.required'    => 'Número documento é obrigatório.',
            'doc_numero.max'         => 'Número documento aceita até :max caracteres.',
            'perfil.required'        => 'Perfil é obrigatório.',
            'perfil.in'              => 'Perfil aceita somente (Proprietário, Cliente Interessado).',
            'fase.required'          => 'Fase é obrigatória.',
            'fase.in'                => 'Fase aceita somente (Novo, Em Atendimento, Com Proposta,Ganhou, Perdeu, Inativo).',
            'tipo.required'          => 'Tipo de pessoa é obrigatória.',
            'tipo.in'                => 'Tipo de pessoa aceita somente (Pessoa Física, Pessoa Jurídica).',
            'investidor.required'    => 'Investidor é obrigatório.',
            'investidor.in'          => 'Investidor aceita somente (Sim, Não).',
            'origem.required'        => 'Origem é obrigatórias.',
            'origem.in'              => 'Origem aceita somente (Email, Jornal, Pessoal, Placa, Revista, Site, Telefone, Outros).',
        ];
    }
}