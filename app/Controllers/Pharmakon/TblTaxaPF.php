<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblTaxaPF AS TblTaxaPFModel;

class TblTaxaPF extends \App\Controllers\BaseController
{
    public function buscarAnoReferenciaAnuidadePF() 
    {
        $TblTaxaPFModel = new TblTaxaPFModel();
        $InscricaoPJId = $this->request->getGet('InscricaoPFId') ?? ''; 
        $Ano = $this->request->getGet('Ano') ?? null; 
        return $this->response->setJSON( $TblTaxaPFModel->selectAnoReferenciaAnuidadePF($InscricaoPJId, $Ano) ); 
    }
}
