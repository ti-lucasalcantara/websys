<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblPF AS TblPFModel;

class TblPF extends \App\Controllers\BaseController
{
    public function buscar() 
    {
        $tblPFModel = new TblPFModel();

        $termo_buscado = $this->request->getGet('termo') ?? ''; 
        $valor_buscado = $this->request->getGet('valor') ?? ''; 

        return $this->response->setJSON( $tblPFModel->selectBuscarPF($termo_buscado, $valor_buscado) ); 
    }

    public function dadosInscricao() 
    {
        $tblPFModel = new TblPFModel();
        $InscricaoPFId = $this->request->getPost('InscricaoPFId') ?? ''; 
        return $this->response->setJSON(  $tblPFModel->getPF($InscricaoPFId) ); 
    }
}
