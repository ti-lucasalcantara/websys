<?php

namespace App\Models;

use CodeIgniter\Model;

class TbUsuario extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'tb_usuario';
    protected $primaryKey       = 'id_usuario';
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
        'login' => 'required|min_length[3]|max_length[100]',
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
        'login' => [
            'required'   => 'Campo obrigatório.',
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
    protected $afterFind      = [];
    protected $beforeDelete   = ['userDeleted'];
    protected $afterDelete    = [];

    
    protected function userCreated($data) {
        $data['data']['user_created'] = 1; 
        return $data;
    }

    protected function userUpdated($data) {
        $data['data']['user_updated'] = 1; 
        return $data;
    }

    protected function userDeleted($data) {
        $data['data']['user_deleted'] = 1; 
        return $data;
    }

    public function selectBuscarUsuario($termo=null, $valor=null)
    {
        $where = '';

        if (!is_null($termo) && !empty($termo) && !is_null($valor) && !empty($valor))
        {
            $where = <<<WHERE
                       AND $termo LIKE '$valor%'
                    WHERE;
        }

        $sql = <<<SQL
                SELECT 
                    u.id_usuario as id
                    ,u.nome as text
                    ,u.id_usuario 
                    ,u.nome 
                    ,u.login
                    ,u.cargo
                    ,u.cpf
                    ,u.email
                    ,u.telefone
                    ,u.avatar
                    ,rs.id_setor
                    ,rs.setor
                    ,rs.gerencia
                    ,rs.sigla
                FROM tb_usuario u
                LEFT JOIN ref_setor rs ON (rs.id_setor=u.id_setor)
                WHERE
                    1=1 
                    AND u.id_usuario NOT IN (1)
                    $where
                ORDER BY u.nome ASC
                LIMIT 100;
        SQL;

        return $this->db->query( $sql )->getResultArray();
    }
}
