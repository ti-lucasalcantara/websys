<?php

namespace App\Controllers\Pharmakon;

use App\Models\Pharmakon\TblPJPropriedade AS TblPJPropriedadeModel;

class TblPJPropriedade extends \App\Controllers\BaseController
{
    public function buscarProprietarios() 
    {
        $TblPJPropriedadeModel = new TblPJPropriedadeModel();
        $InscricaoPJId  = $this->request->getGet('InscricaoPJId') ?? ''; 
        $ProprietarioId = $this->request->getGet('ProprietarioId') ?? null; 
        return $this->response->setJSON( $TblPJPropriedadeModel->selectProprietarios($InscricaoPJId, $ProprietarioId) ); 
    }
}
