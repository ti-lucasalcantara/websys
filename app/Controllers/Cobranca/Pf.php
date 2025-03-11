<?php

namespace App\Controllers\Cobranca;

use App\Models\Pharmakon\TblPF AS TblPFModel;

class Pf extends \App\Controllers\BaseController
{
    private $dados;

    public function __construct(){
        $this->dados = array();
        $this->dados['titulo_pagina'] = "Inscrição PF";
    }

    public function index($InscricaoPFId=null, $tab='debitos')
    {
        $this->dados['tab'] = $tab;
        $this->dados['pf']  = is_null($InscricaoPFId) || $InscricaoPFId == 0 ? null : (new TblPFModel())->getPF($InscricaoPFId);
        $this->dados['dados_tab'] =  array_merge($this->dados['pf'] ?? [], $this->carregarDadosTab($tab, $InscricaoPFId) );

        return view('cobranca/pf/index', $this->dados);
    }


    private function carregarDadosTab($tab, $InscricaoPFId)
    {
        $metodo = "tab_{$tab}";
        // Verifica se o método existe antes de chamá-lo
        if (method_exists($this, $metodo)) {
            return $this->$metodo($InscricaoPFId);
        }

        // Retorna um array vazio se a aba não tiver um método correspondente
        return []; 
    }

    
}