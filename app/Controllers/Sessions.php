<?php

namespace App\Controllers;

class Sessions extends BaseController
{
    public function sessionInscricaoPFId(){

        $InscricaoPFId = $this->request->getGet('InscricaoPFId');

        if ( !$InscricaoPFId ){
            return $this->response->setJSON( getMessageFail() )->setStatusCode(401);
        }
        
        $session = [
           'buscar'  => [
               'InscricaoPFId'  => $InscricaoPFId,
           ]
       ]; 

       session()->set($session);

       return $this->response->setJSON( getMessageSucess() )->setStatusCode(200);
   }
   
}
