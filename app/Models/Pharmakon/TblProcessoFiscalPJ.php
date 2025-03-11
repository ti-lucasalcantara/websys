<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblProcessoFiscalPJ extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'TblProcessoFiscalPJ';
    protected $primaryKey       = 'NumProcessoFiscal';
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

    public function selectProcessoFiscal($InscricaoPJId=null, $NumProcessoFiscal=null){
        if(is_null($InscricaoPJId) || empty($InscricaoPJId)){
            return [];
        }

        $InscricaoPJId = (int)$InscricaoPJId;

        $where = "";
        if(!is_null($NumProcessoFiscal) && !empty($NumProcessoFiscal)){
            $NumProcessoFiscal = $NumProcessoFiscal;
            $where .= " AND tpfp.NumProcessoFiscal LIKE '$NumProcessoFiscal%' ";
        }

        $sql = <<<SQL
                SELECT 
                    tpfp.NumProcessoFiscal as id
                    ,tpfp.NumProcessoFiscal as text
                    ,tpfp.NumProcessoFiscal
                    ,tap.NumAutuacaoPJ 
                    ,tap.DataAutuacao 
                    ,CONVERT(VARCHAR(255), tap.DataAutuacao, 103) AS DataAutuacaoPTBR
                    ,tpfp.StatusProcessualId
                    ,rsp.StatusProcessual
                    ,tpfp.MotivoArquivamentoId
                    ,rma.MotivoArquivamento
                    ,(SELECT top 1 auxtmfp.ValorMulta FROM tblMultaFiscalPJ auxtmfp WHERE auxtmfp.NumProcessoFiscalPJ=tpfp.NumProcessoFiscal ORDER BY DataEmissao ASC) AS "ValorDebito"
                    ,(SELECT SUM(aux2tmfp.ValorMulta) AS "Valor" FROM tblMultaFiscalPJ aux2tmfp WHERE aux2tmfp.NumProcessoFiscalPJ=tpfp.NumProcessoFiscal AND aux2tmfp.Status IN (1)) AS "SaldoDevedor"
                FROM tblProcessoFiscalPJ tpfp 
                INNER JOIN tblAutuacaoPJ tap ON (tap.NumProcessoFiscal=tpfp.NumProcessoFiscal)
                LEFT JOIN refStatusProcessual rsp ON (tpfp.StatusProcessualId=rsp.StatusProcessualId)
                LEFT JOIN refMotivoArquivamento rma ON (tpfp.MotivoArquivamentoId=rma.MotivoArquivamentoId)
                WHERE tpfp.InscricaoPJId = ?
                $where
                ORDER BY tpfp.NumProcessoFiscal ASC 
        SQL;
        
        return $this->db->query($sql, [$InscricaoPJId])->getResultArray();
    }

}
