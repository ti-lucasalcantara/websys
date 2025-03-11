<?php

namespace App\Services;

use CodeIgniter\Config\BaseService;
use App\Models\TbPermissao;
use App\Models\TbUsuarioPerfil;


class Permissoes extends BaseService
{
    public function validarAcesso($key_permissao) 
    {
        if (!$key_permissao) {
            return ['acesso' => false, 'messagem' => 'Chave de permissão não informada', 'status' => 401 ];
        }
        
        $id_usuario = session('usuario_logado')['id_usuario'] ?? null;
        if (!$id_usuario) {
            return ['acesso' => false, 'messagem' => 'Usuário não autenticado', 'status' => 401];
        }

        $permissao = (new TbPermissao())->where('key', $key_permissao)->first();
        if (!$permissao) {
            return ['acesso' => false, 'messagem' => 'Permissão não encontrada', 'status' => 401];
        }
    
        // Verifica se o usuário tem um perfil vinculado a essa permissão
        $temAcesso = (new TbUsuarioPerfil())
            ->join('tb_permissao_perfil', 'tb_usuario_perfil.id_perfil = tb_permissao_perfil.id_perfil')
            ->where('tb_usuario_perfil.id_usuario', $id_usuario)
            ->where('tb_permissao_perfil.id_permissao', $permissao['id_permissao'])
            ->countAllResults();
    
        return ['acesso' => $temAcesso > 0, 'messagem' => $temAcesso > 0 ? 'Acesso concedido' : 'Acesso negado', 'status' => 200];
    }
  
}