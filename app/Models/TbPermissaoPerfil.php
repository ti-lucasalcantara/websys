<?php

namespace App\Models;

use CodeIgniter\Model;

class TbPermissaoPerfil extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'tb_permissao_perfil';
    protected $primaryKey       = 'id_permissao_perfil';
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

    public function toggle($id_perfil, $id_permissao)
    {
        $permissaoPerfil = $this->where('id_perfil', $id_perfil)
                                ->where('id_permissao', $id_permissao)
                                ->first();

        if ($permissaoPerfil) {
            // Se a vinculação existir, desvincula (marcando com deleted_at)
            if ($permissaoPerfil['deleted_at'] === null) {
                return $this->update($permissaoPerfil['id_permissao_perfil'], ['deleted_at' => date('Y-m-d H:i:s')]);
            }
            // Caso contrário, já está desvinculado
            return false;
        } else {
            // Se não existir, cria a nova vinculação
            return $this->insert([
                'id_perfil'    => $id_perfil,
                'id_permissao' => $id_permissao,
            ]);
        }
    }
}
