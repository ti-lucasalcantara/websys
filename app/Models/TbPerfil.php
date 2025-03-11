<?php

namespace App\Models;

use CodeIgniter\Model;

class TbPerfil extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'tb_perfil';
    protected $primaryKey       = 'id_perfil';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nome'  => 'required|min_length[3]|max_length[255]',
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['userCreated'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['userUpdated'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['afterFind'];
    protected $beforeDelete   = ['userDeleted'];
    protected $afterDelete    = [];

    
    protected function userCreated($data) {
        $data['data']['user_created'] = session('usuario_logado')['id_usuario']; 
        return $data;
    }

    protected function userUpdated($data) {
        $data['data']['user_updated'] = session('usuario_logado')['id_usuario']; 
        return $data;
    }

    protected function userDeleted($data) {
        $data['data']['user_deleted'] = session('usuario_logado')['id_usuario']; 
        return $data;
    }

    protected function afterFind($data) {
        
        $dados = $data['data'];
        if ( !empty($dados) )
        {
            foreach ($dados as $key => $value) {
                if ( isset($dados[$key]['id_perfil']) ){
                    $dados[$key]['usuarios'] = (new TbUsuarioPerfil())->where('id_perfil', $dados[$key]['id_perfil'])->findAll();
                    $dados[$key]['permissoes'] = (new TbPermissaoPerfil())->join('tb_permissao', 'tb_permissao_perfil.id_permissao = tb_permissao.id_permissao')->where('id_perfil', $dados[$key]['id_perfil'])->findAll();
                }
            }
        }
        $data['data'] = $dados;
        
        return $data;
    }


}
