<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblPJ AS TblPJModel;

class TblPJ extends \App\Controllers\BaseController
{
    public function buscar() 
    {
        $TblPJModel = new TblPJModel();

        $termo_buscado = $this->request->getGet('termo') ?? ''; 
        $valor_buscado = $this->request->getGet('valor') ?? ''; 

        return $this->response->setJSON( $TblPJModel->selectBuscarPJ($termo_buscado, $valor_buscado) ); 
    }

    public function dadosInscricao() 
    {
        $TblPJModel = new TblPJModel();
        $InscricaoPJId = $this->request->getPost('InscricaoPJId') ?? ''; 
        return $this->response->setJSON(  $TblPJModel->getPJ($InscricaoPJId) ); 
    }
}
