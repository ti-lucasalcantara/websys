<?php

namespace App\Controllers;

use \App\Models\TbUsuario;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function entrar() {
        
        if ( ! $this->request->is('post') ) {
            session()->setFlashdata( getMessageFail() );
            return redirect()->back()->withInput();   

        }else{

            $rules = [
                'usuario' => 'required|min_length[3]|max_length[255]',
                'senha'   => 'required|min_length[3]|max_length[255]',
            ];

            $messages   = [
                'usuario' => [
                    'required' => 'Campo obrigatório.',
                    'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
                    'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
                ],
                'senha' => [
                    'required' => 'Campo obrigatório.',
                    'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
                    'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
                ],
            ];

            $validation = \Config\Services::validation();
            $validation->setRules($rules, $messages);

            if (! $validation->run($this->request->getPost()) ) {
                return redirect()->back()->withInput();   
            }

            $curl = curl_init();
			curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/apildap/sessions/login' );
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'usuario' =>  $this->request->getPost('usuario'),
				'senha'   =>  $this->request->getPost('senha'),
			));
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			$response = json_decode( curl_exec( $curl ), true);
			curl_close($curl);
            if ( ! $response ){
                session()->setFlashdata( getMessageFail('sweetalert', ['title' => 'Falha no login', 'text' => 'Falha ao comunicar com o servidor [API]']) );
                return redirect()->back()->withInput();   
			}

			if ( $response['type'] == "error"){
                session()->setFlashdata( getMessageFail('toast', ['title' => 'Falha no login', 'text' => $response['message']]) );
                return redirect()->back()->withInput();   
			}

            $nome   = $response['nome'];
            $login  = $response['usuario'];
           #$setor  = $response['setor'];

            // Cria ou atualiza usuário
            $dados_bd = [
                'nome'  => $nome,
                'login' => $login,
            ];

            $Usuarios = new TbUsuario(); 
            
            $user = $Usuarios->where('login', $login)->first();
            
            if (!empty($user)) {

                if($user['ativo'] != 1){
                    session()->setFlashdata( getMessageFail('sweetalert', ['title' => 'Falha no login', 'text' => 'Usuário sem permissão de acesso']) );
                    return redirect()->back()->withInput();  
                }

                // Atualiza dados do usuário (AD) no banco de dados
                $dados_bd['id_usuario'] = $user['id_usuario'];
            }

            if (!$Usuarios->save($dados_bd)) {
                session()->setFlashdata(getMessageFail('sweetalert', ['title' => 'Falha no login', 'text' => implode(",", $Usuarios->errors())]));
                return redirect()->back()->withInput();
            }

            if (empty($user)) {
                // Se criou um novo usuário, recupera as informações
                $user = $Usuarios->find($Usuarios->getInsertID());
            }

            // Criar sessão de LOGIN
            $session = [
                'usuario_logado'  => [
                    'id_usuario'  => $user['id_usuario'],
                    'id_setor'    => $user['id_setor'],
                    'nome'        => $user['nome'],
                    'login'       => $user['login'],
                    'cpf'         => $user['cpf'],
                    'email'       => $user['email'],
                    'cargo'       => $user['cargo'],
                    'ativo'       => $user['ativo'],
                    'avatar'      => $user['avatar'],
                ]
            ]; 
                        
            session()->set($session); 
            return redirect()->route('home');
        }
    }

    public function sair() {
        session()->destroy();
        return redirect()->route('login');
    }
    
}
