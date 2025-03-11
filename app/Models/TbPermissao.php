<?php

namespace App\Models;

use CodeIgniter\Model;

class TbPermissao extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'tb_permissao';
    protected $primaryKey       = 'id_permissao';
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
    public $validationRules      = [
        'key'           => 'required|min_length[3]|max_length[255]|is_unique[tb_permissao.key]',
        'nome'          => 'required|min_length[3]|max_length[255]',
    ];
    public $validationMessages   = [
        'key' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
            'is_unique' => 'Chave usada anteriormente. A Chave deve ser única.',
        ],
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
                if ( isset($dados[$key]['id_permissao']) ){
                    $dados[$key]['perfis'] = (new TbPermissaoPerfil())->where('id_permissao', $dados[$key]['id_permissao'])->findAll();
                }
            }
        }
        $data['data'] = $dados;
        
        return $data;
    }

}
