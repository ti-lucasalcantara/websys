<?php

namespace App\Models;

use CodeIgniter\Model;

class TbRefSetor extends Model
{
    protected $DBGroup          = 'websys';
    protected $table            = 'ref_setor';
    protected $primaryKey       = 'id_setor';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'setor'     => 'required|min_length[3]|max_length[255]',
        'gerencia'  => 'required|min_length[3]|max_length[255]',
        'sigla'     => 'required|min_length[3]|max_length[255]',
    ];
    protected $validationMessages   = [
        'setor' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
        'gerencia' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
        'sigla' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


}
