<?php

namespace App\Controllers\Registro;

use App\Models\Pharmakon\TblPF AS TblPFModel;

class Pf extends \App\Controllers\BaseController
{
    private $dados;

    public function __construct(){
        $this->dados = array();
        $this->dados['titulo_pagina'] = "Inscrição PF";
    }

    public function index($InscricaoPFId=null, $tab='inscricao')
    {
        $this->dados['tab'] = $tab;
        $this->dados['pf']  = is_null($InscricaoPFId) || $InscricaoPFId == 0 ? null : (new TblPFModel())->getPF($InscricaoPFId);
        $this->dados['dados_tab'] =  array_merge($this->dados['pf'] ?? [], $this->carregarDadosTab($tab, $InscricaoPFId) );

        return view('registro/pf/index', $this->dados);
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


    // metodos das Tabs
    public function tab_inscricao($InscricaoPFId=null){

        $TblPFModel = new TblPFModel();

        return [
            'protocolos' => $TblPFModel->getProtocolos($InscricaoPFId),
        ];
    }

    public function tab_contatos($InscricaoPFId=null){

        $TblPFModel = new TblPFModel();

        return [
            'endereco' => $TblPFModel->getEndereco($InscricaoPFId),
            'contatos' => $TblPFModel->getContatos($InscricaoPFId),
        ];
    }

    
}