<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblPJPropriedade extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'tblPJPropriedade';
    protected $primaryKey       = 'ProprietarioId';
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

    public function selectProprietarios($InscricaoPJId=null,$ProprietarioId=null){
       
        if(is_null($InscricaoPJId) || empty($InscricaoPJId)){
            return [];
        }

        $InscricaoPJId = (int)$InscricaoPJId;

        $where = "";
        if (isset($ProprietarioId) && !empty($ProprietarioId)){
            $ProprietarioId = (int)$ProprietarioId;
            $where = " WHERE id='$ProprietarioId' ";
        }

        $sql = <<<SQL
                SELECT *
                FROM (
                    SELECT 
                    pj.InscricaoPJId AS id
                    ,'ENDEREÇO DO ESTABELECIMENTO' AS text
                    ,'' AS "ProprietarioId"
                    ,'' AS "QuantidadeCotas"
                    ,'' AS "Nome"
                    ,'' AS "Farmaceutico"
                    ,'' AS "InscricaoPFId"
                    ,pj.Endereco 
                    ,pj.Cep
                    ,rb.Bairro 
                    ,rc.Cidade 
                    ,rc.Uf
                    ,rdrs.DRS 
                    ,rsec.Seccional 
                    ,0 AS OrderCol
                    FROM tblpj pj 
                    LEFT JOIN refBairro rb ON (pj.BairroId = rb.BairroID )
                    LEFT JOIN refCidade rc ON (rb.CidadeId=rc.CidadeID)
                    LEFT JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)
                    LEFT JOIN refSeccional rsec  ON (rdrs.SecionalId=rsec.SeccionalId)
                    where pj.InscricaoPJId = ?

                    UNION

                    SELECT 
                        pjprop.ProprietarioId as id
                        ,CAST(CAST(pjprop.QuantidadeCotas AS DECIMAL(10, 2) ) AS VARCHAR) +'% - '+ UPPER(CASE WHEN (pf.InscricaoPFId IS NOT NULL) THEN pf.NomePF ELSE prop.Proprietario END)  as text
                        ,pjprop.ProprietarioId 
                        ,pjprop.QuantidadeCotas
                        ,CASE WHEN (pf.InscricaoPFId IS NOT NULL) THEN pf.NomePF ELSE prop.Proprietario END AS "Nome"
                        ,pjprop.Farmaceutico 
                        ,pf.InscricaoPFId 
                        ,CASE WHEN (pf.InscricaoPFId IS NOT NULL) THEN pf.Endereco ELSE prop.Endereco END AS "Endereco"
                        ,CASE WHEN (pf.InscricaoPFId IS NOT NULL) THEN pf.Cep ELSE prop.Cep END AS "Cep"
                        ,rb.Bairro 
                        ,rc.Cidade 
                        ,rc.Uf
                        ,rdrs.DRS 
                        ,rsec.Seccional 
                        ,1 AS OrderCol 
                    FROM tblPJPropriedade pjprop  
                    LEFT JOIN tblPF pf ON (pjprop.InscricaoPFId=pf.InscricaoPFId)
                    LEFT JOIN tblProprietario prop ON (pjprop.ProprietarioNaoFarmaceutico=prop.CpfCgc) 
                    LEFT JOIN refBairro rb ON (CASE WHEN (pf.InscricaoPFId IS NOT NULL) THEN pf.BairroId ELSE prop.BairroId END = rb.BairroID )
                    LEFT JOIN refCidade rc ON (rb.CidadeId=rc.CidadeID)
                    LEFT JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)
                    LEFT JOIN refSeccional rsec  ON (rdrs.SecionalId=rsec.SeccionalId)
                    where pjprop.InscricaoPJId= ?

                ) AS SubQuery
                $where 
                ORDER BY OrderCol, Nome ASC

        SQL;
        
        return $this->db->query($sql, [$InscricaoPJId, $InscricaoPJId])->getResultArray();
    }

}
