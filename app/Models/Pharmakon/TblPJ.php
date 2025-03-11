<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblPJ extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'TblPJ';
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


    public function getPJ($InscricaoPJId=null){
        if(is_null($InscricaoPJId) || empty($InscricaoPJId)){
            return [];
        }

        $InscricaoPJId = (int)$InscricaoPJId;

        $sql = <<<SQL
                SELECT 
                    tp.InscricaoPJId
                    ,CAST(tp.DataInscricao AS DATE) AS "DataInscricao"
                    ,tp.RazaoSocial 
                    ,tp.NomeFantasia 
                    ,tp.IsentoAnuidade 
                    ,tp.StatusCadastralPJId 
                    ,rscp.StatusCadastralPJ  
                    ,tpcom.Cgc 
                    ,tp.Endereco
                    ,tp.Cep
                    ,rb.Bairro
                    ,rc.Cidade
                    ,rc.Uf
                    ,rdrs.DRS
                FROM tblPJ tp
                INNER JOIN refStatusCadastralPJ rscp ON (tp.StatusCadastralPJId =rscp.StatusCadastralPJId )
                LEFT JOIN tblPJComplemento tpcom ON (tp.InscricaoPJId=tpcom.InscricaoPJId)
                INNER JOIN refBairro rb ON (tp.BairroId=rb.BairroId)
                INNER JOIN refCidade rc ON (rb.CidadeId=rc.CidadeId)
                INNER JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)
                WHERE tp.InscricaoPJId = ?
        SQL;
        
        return $this->db->query($sql, [$InscricaoPJId])->getRowArray();
    }

    public function selectBuscarPJ($termo=null, $valor=null)
    {
        $where = '';

        if (!is_null($termo) && !empty($termo) && !is_null($valor) && !empty($valor))
        {
            if ( $termo == 'InscricaoPJId' ){
                $termo = 'tp.InscricaoPJId';
            }
            
            $where = <<<WHERE
                       AND $termo LIKE '$valor%'
                    WHERE;
        }

        $sql = <<<SQL
                SELECT 
                    top 100
                    tp.InscricaoPJId as id
                    ,tp.RazaoSocial as text
                    ,tp.InscricaoPJId
                    ,CAST(tp.DataInscricao AS DATE) AS "DataInscricao"
                    ,tp.RazaoSocial 
                    ,tp.NomeFantasia 
                    ,tp.IsentoAnuidade 
                    ,tp.StatusCadastralPJId 
                    ,rscp.StatusCadastralPJ  
                    ,tpcom.Cgc 
                    ,tp.Endereco
                    ,tp.Cep
                    ,rb.Bairro
                    ,rc.Cidade
                    ,rc.Uf
                    ,rdrs.DRS
                FROM tblPJ tp
                INNER JOIN refStatusCadastralPJ rscp ON (tp.StatusCadastralPJId =rscp.StatusCadastralPJId )
                LEFT JOIN tblPJComplemento tpcom ON (tp.InscricaoPJId=tpcom.InscricaoPJId)
                INNER JOIN refBairro rb ON (tp.BairroId=rb.BairroId)
                INNER JOIN refCidade rc ON (rb.CidadeId=rc.CidadeId)
                INNER JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)
                WHERE
                    1=1 
                    $where
                ORDER BY tp.RazaoSocial ASC;
        SQL;


        return $this->db->query( $sql )->getResultArray();
    }

}
