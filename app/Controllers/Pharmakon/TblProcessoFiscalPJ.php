<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblProcessoFiscalPJ AS TblProcessoFiscalPJModel;

class TblProcessoFiscalPJ extends \App\Controllers\BaseController
{
    public function buscarProcessoFiscal() 
    {
      
        $TblProcessoFiscalPJModel = new TblProcessoFiscalPJModel();
        $InscricaoPJId = $this->request->getGet('InscricaoPJId') ?? ''; 
        $NumProcessoFiscal = $this->request->getGet('NumProcessoFiscal') ?? null; 
        return $this->response->setJSON( $TblProcessoFiscalPJModel->selectProcessoFiscal($InscricaoPJId, $NumProcessoFiscal) ); 
    }
}
