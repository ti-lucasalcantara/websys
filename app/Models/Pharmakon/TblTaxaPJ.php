<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblTaxaPJ extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'TblTaxaPJ';
    protected $primaryKey       = 'InscricaoPJId';
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


   
    public function selectAnoReferenciaAnuidadePJ($InscricaoPJId=null, $Ano=null){
        if(is_null($InscricaoPJId) || empty($InscricaoPJId)){
            return [];
        }

        $InscricaoPJId = (int)$InscricaoPJId;

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
                    ,ttp.Valor as "ValorDebito"
                    ,(SELECT SUM(auxtbp.Valor) AS "Valor" FROM tblBoletaPJ auxtbp WHERE auxtbp.NumBoletaPJ IN (
                            SELECT auxttbp.NumBoletaPJ FROM tblTaxaBoletaPJ auxttbp WHERE auxttbp.TipoTaxaId=ttp.TipoTaxaId and auxttbp.InscricaoPJId=ttp.InscricaoPJId and auxttbp.Ano=ttp.Ano
                        ) and auxtbp.Status IN (1)
                    ) as "SaldoDevedor"
                    ,ttp.InscricaoPJId 
                FROM tblTaxaPJ ttp 
                INNER JOIN refTipoTaxa rtt ON (ttp.TipoTaxaId=rtt.TipoTaxaId)
                INNER JOIN refStatusPagamento rsp ON (ttp.Status=rsp.StatusPagamentoId)
                WHERE ttp.InscricaoPJId = ?
                AND ttp.TipoTaxaId IN (2,3,4,5,6,7,8)
                $where
                ORDER BY ttp.Ano ASC 

        SQL;
        
        return $this->db->query($sql, [$InscricaoPJId])->getResultArray();
    }

}
