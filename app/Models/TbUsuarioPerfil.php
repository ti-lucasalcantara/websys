<?php

namespace App\Models;

use CodeIgniter\Model;

class TbUsuarioPerfil extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'tb_usuario_perfil';
    protected $primaryKey       = 'id_usuario_perfil';
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
    ];
    protected $validationMessages   = [
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
    protected $afterFind      = [];
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
}
