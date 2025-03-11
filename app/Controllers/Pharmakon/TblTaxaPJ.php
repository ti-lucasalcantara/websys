<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblTaxaPJ AS TblTaxaPJModel;

class TblTaxaPJ extends \App\Controllers\BaseController
{
    public function buscarAnoReferenciaAnuidadePJ() 
    {
        $TblTaxaPJModel = new TblTaxaPJModel();
        $InscricaoPJId = $this->request->getGet('InscricaoPJId') ?? ''; 
        $Ano = $this->request->getGet('Ano') ?? null; 
        return $this->response->setJSON( $TblTaxaPJModel->selectAnoReferenciaAnuidadePJ($InscricaoPJId, $Ano) ); 
    }
}
