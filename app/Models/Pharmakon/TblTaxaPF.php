<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblTaxaPF extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'TblTaxaPF';
    protected $primaryKey       = 'InscricaoPFId';
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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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


   
    public function selectAnoReferenciaAnuidadePF($InscricaoPFId=null, $Ano=null){
        if(is_null($InscricaoPFId) || empty($InscricaoPFId)){
            return [];
        }

        $InscricaoPFId = (int)$InscricaoPFId;

        $where = "";
        if(!is_null($Ano) && !empty($Ano)){
            $Ano = (int)$Ano;
            $where .= " AND ttp.Ano LIKE '$Ano%' ";
        }

        $sql = <<<SQL
                SELECT 
                    DISTINCT
                    CAST(ttp.Ano AS INT) as id
                    ,ttp.Ano as text
                    ,ttp.Ano
                    ,ttp.TipoTaxaId
                    ,rtt.TipoTaxa
                    ,ttp.Status 
                    ,rsp.StatusPagamento 
                FROM tblTaxaPF ttp 
                INNER JOIN refTipoTaxa rtt ON (ttp.TipoTaxaId=rtt.TipoTaxaId)
                INNER JOIN refStatusPagamento rsp ON (ttp.Status=rsp.StatusPagamentoId)
                WHERE ttp.InscricaoPFId = ?
                AND ttp.TipoTaxaId IN (1)
                $where
                ORDER BY ttp.Ano ASC 
        SQL;
        
        return $this->db->query($sql, [$InscricaoPFId])->getResultArray();
    }

}
