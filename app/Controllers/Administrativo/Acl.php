<?php

namespace App\Controllers\Administrativo;

use App\Models\TbPerfil;
use App\Models\TbPermissao;
use App\Models\TbPermissaoPerfil;
use App\Models\TbUsuarioPerfil;
use App\Models\TbUsuario;

class Acl extends \App\Controllers\BaseController
{
    private $dados;

    public function __construct(){
        $this->dados = array();
        $this->dados['titulo_pagina'] = "Controle de Acesso";
    }
    
    public function validarPermissao() {
        return $this->response->setJSON( service('permissoes')->validarAcesso( $this->request->getGet('key_permissao') ) )->setStatusCode(200);
    }

    public function index($id_perfil=null, $tab='perfil')
    {
        $TbPerfil = new TbPerfil();

        if(!is_null($id_perfil)){
            $id_perfil = base64_decode($id_perfil);
        }

        $this->dados['tab']     = $tab;
        $this->dados['perfis']  = $TbPerfil->select('tb_perfil.*, COUNT(tb_usuario_perfil.id_perfil) as qtd_usuarios')
                                            ->join('tb_usuario_perfil', 'tb_usuario_perfil.id_perfil = tb_perfil.id_perfil AND tb_usuario_perfil.id_usuario != 1', 'left')
                                            ->where('tb_usuario_perfil.deleted_at IS NULL')
                                            ->groupBy('tb_perfil.id_perfil')
                                            ->orderBy('tb_perfil.nome', 'asc')
                                            ->findAll();

        $this->dados['perfil_selecionado'] = is_null($id_perfil) ? null : $TbPerfil->find($id_perfil);

        if($tab == 'permissoes'){
            $this->dados['permissoes'] = (new TbPermissao())->findAll();
            $this->dados['permissoes_perfil'] = (new TbPermissaoPerfil())->where('id_perfil', $id_perfil)->findAll();
        }

        if($tab == 'usuarios'){
            $this->dados['usuarios_perfil'] = (new TbUsuarioPerfil())
                                        ->join('tb_usuario', 'tb_usuario.id_usuario = tb_usuario_perfil.id_usuario')
                                        ->join('ref_setor', 'tb_usuario.id_setor = ref_setor.id_setor', 'LEFT')
                                        ->where('tb_usuario_perfil.id_perfil', $id_perfil)
                                        ->orderBy('tb_usuario.nome', 'ASC')
                                        ->findAll();
        }

        return view('administrativo/acl/index', $this->dados);
    }

    public function criarPerfil()
    {
        if ( ! $this->request->is('post') ) {
            return $this->response->setJSON( getMessageFail() )->setStatusCode(500);
        }else{
            $TbPerfil = new TbPerfil();

            $rules = [
                'nome' => 'required|min_length[3]|max_length[255]',
            ];

            $messages   = [
                'nome' => [
                    'required' => 'Campo obrigatório.',
                    'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
                    'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
                ],
            ];

            $validation = \Config\Services::validation();
            $validation->setRules($rules, $messages);

            if (! $validation->run($this->request->getPost())) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'formValidation' => $validation->getErrors()
                ])->setStatusCode(422);
            }

            $dados['nome']      = $this->request->getPost('nome');
            $dados['descricao'] = $this->request->getPost('descricao');

            if (!$TbPerfil->save($dados)) {
                return $this->response->setJSON( getMessageFail() )->setStatusCode(500);
            }

            return $this->response->setJSON( getMessageSucess() )->setStatusCode(200);
        }
    }

    public function togglePermissaoAoPerfil()
    {
        if ( ! $this->request->is('post') ) {
            return $this->response->setJSON( getMessageFail() )->setStatusCode(500);
        }else{

            $id_perfil = $this->request->getPost('id_perfil');
            $id_permissao = $this->request->getPost('id_permissao');

            if (!(new TbPermissaoPerfil())->toggle($id_perfil, $id_permissao)) {
                return $this->response->setJSON( getMessageFail() )->setStatusCode(500);
            }else{
                return $this->response->setJSON( getMessageSucess() )->setStatusCode(200);
            }
        }
    }

    public function buscarUsuarios() 
    {
        $TbUsuario = new TbUsuario();

        $termo_buscado = $this->request->getGet('termo') ?? ''; 
        $valor_buscado = $this->request->getGet('valor') ?? ''; 

        return $this->response->setJSON( $TbUsuario->selectBuscarUsuario($termo_buscado, $valor_buscado) )->setStatusCode(200); 
    }

    public function vincularUsuarioPerfil() 
    {
        if ( ! $this->request->is('post') ) {
            session()->setFlashdata( getMessageFail() );
            return redirect()->back()->withInput();   

        }else{

            $rules = [
                'id_usuario' => 'required',
                'id_perfil'  => 'required',
            ];

            $messages   = [
                'id_usuario' => [
                    'required' => 'Campo obrigatório.',
                ],
                'id_perfil' => [
                    'required' => 'Campo obrigatório.',
                ],
            ];

            $validation = \Config\Services::validation();
            $validation->setRules($rules, $messages);

            if (! $validation->run($this->request->getPost()) ) {
                return redirect()->back()->withInput();   
            }

            $TbUsuarioPerfil = new TbUsuarioPerfil();
            $perfil = $TbUsuarioPerfil->where('id_perfil', $this->request->getPost('id_perfil') )->where('id_usuario', $this->request->getPost('id_usuario') )->findAll();

            if(!empty($perfil)){
                session()->setFlashdata( getMessageSucess('toast', ['text' => 'Usuário já pertencente ao perfil']) );
                return redirect()->back()->withInput();  
            }else{
                $dados = array();
                $dados['id_perfil'] = $this->request->getPost('id_perfil');
                $dados['id_usuario'] = $this->request->getPost('id_usuario');

                if(!$TbUsuarioPerfil->save($dados)){
                    session()->setFlashdata( getMessageFail('sweetalert', ['text'=> 'Falha ao salvar usuário']) );
                    return redirect()->back()->withInput();  
                }

                session()->setFlashdata( getMessageSucess('sweetalert') );
                return redirect()->back()->withInput();  
            }

            
        }
    }

    public function desvincularUsuarioPerfil() 
    {
        if ( ! $this->request->is('post') ) {
            return $this->response->setJSON( getMessageFail() )->setStatusCode(401);
        }else{
            if(! (new TbUsuarioPerfil())->delete($this->request->getPost('id')) ){
                return $this->response->setJSON( getMessageFail() )->setStatusCode(401);
            }else{
                return $this->response->setJSON( getMessageSucess() )->setStatusCode(200);
            }
        }
    }
}