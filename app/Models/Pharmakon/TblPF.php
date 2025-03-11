<?php

namespace App\Models\Pharmakon;

use CodeIgniter\Model;

class TblPF extends Model
{
    protected $DBGroup          = 'pharmakon';
    protected $table            = 'TblPF';
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


    public function getPF($InscricaoPFId=null){
        if(is_null($InscricaoPFId) || empty($InscricaoPFId)){
            return [];
        }

        $InscricaoPFId = (int)$InscricaoPFId;

        $sql = <<<SQL
                SELECT 
                    tp.InscricaoPFId
                    ,CAST(tp.DataInscricao AS DATE) AS "DataInscricao"
                    ,tp.NomePF
                    ,CAST(tpcom.DataNascimento AS DATE) AS "DataNascimento"
                    ,tp.StatusCadastralId
                    ,rscp.StatusCadastral 
                    ,tpcom.Cpf
                    ,tpcom.Sexo
                    ,tp.Endereco
                    ,tp.Cep
                    ,rb.Bairro
                    ,rc.Cidade
                    ,rc.Uf
                    ,rdrs.DRS
                FROM tblPF tp
                INNER JOIN refStatusCadastralPF rscp ON (tp.StatusCadastralId=rscp.StatusCadastralId)
                LEFT JOIN tblPFComplemento tpcom ON (tp.InscricaoPFId=tpcom.InscricaoPFId)
                INNER JOIN refBairro rb ON (tp.BairroId=rb.BairroId)
                INNER JOIN refCidade rc ON (rb.CidadeId=rc.CidadeId)
                INNER JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)
                WHERE tp.InscricaoPFId = ?
        SQL;
        
        return $this->db->query($sql, [$InscricaoPFId])->getRowArray();
    }

    public function getProtocolos($InscricaoPFId=null){
        if(is_null($InscricaoPFId) || empty($InscricaoPFId)){
            return [];
        }

        $InscricaoPFId = (int)$InscricaoPFId;

        $sql = <<<SQL
                SELECT 
                    pr.ContadorAccess
                    ,pr.Contador
                    ,pr.[Data]
                    ,pr.DataProtocolo
                    ,pr.DataEntregaSetor
                    ,pr.SetorDestino 
                    ,a.AssuntoID 
                    ,a.Assunto
                    ,pr.[Anotação1] AS "Anotacao1"
                    ,pr.[Anotação2] AS "Anotacao2"
                FROM 
                Protocolo.proto_reg pr 
                LEFT JOIN Protocolo.Assunto a ON (pr.Assunto=a.AssuntoID )
                where 
                Remetente = ? 
                AND pr.TipoPessoa=0
                ORDER BY [Data] DESC
        SQL;
        
        return $this->db->query($sql, [$InscricaoPFId])->getResultArray();
    }

    public function getEndereco($InscricaoPFId=null){
        if(is_null($InscricaoPFId) || empty($InscricaoPFId)){
            return [];
        }

        $InscricaoPFId = (int)$InscricaoPFId;

        $sql = <<<SQL
                SELECT  
                    pf.Endereco
                    ,pf.BairroId
                    ,rb.Bairro
                    ,rc.CidadeID
                    ,rc.Cidade
                    ,rc.Uf
                    ,rd.DRSId
                    ,rd.DRS
                    ,rs.SeccionalId
                    ,rs.Seccional
                FROM tblPF pf
                LEFT JOIN refBairro rb ON (pf.BairroId=rb.BairroID)
                LEFT JOIN refCidade rc ON (rb.CidadeId=rc.CidadeID)
                LEFT JOIN refDRS rd ON (rc.DRSId=rd.DRSId)
                LEFT JOIN refSeccional rs ON (rd.SecionalId =rs.SeccionalId )
                where 
                pf.InscricaoPFId = ? 
        SQL;
        
        return $this->db->query($sql, [$InscricaoPFId])->getRowArray();
    }

    public function getContatos ($InscricaoPFId=null){
        if(is_null($InscricaoPFId) || empty($InscricaoPFId)){
            return [];
        }

        $InscricaoPFId = (int)$InscricaoPFId;

        $sql = <<<SQL
                SELECT 
                    CASE 
                        WHEN tp.Numero IS NOT NULL THEN tp.Numero
                        WHEN tp.Texto IS NOT NULL THEN tp.Texto
                        ELSE tp.Link
                    END AS "Contato"
                    ,rtc.TipoContato
                    ,rtc.TipoContatoId
                    ,CASE WHEN tp.zDataAlteracao IS NOT NULL THEN tp.zDataAlteracao ELSE tp.zDataInclusao END AS "DataAlteracao"
                FROM tblPFContato tp 
                LEFT JOIN refTipoContato rtc ON (tp.TipoContatoId = rtc.TipoContatoId)
                WHERE tp.InscricaoPFId = ?
                ORDER BY [TipoContato] ASC;
        SQL;
        
        return $this->db->query($sql, [$InscricaoPFId])->getResultArray();
    }

    public function selectBuscarPF($termo=null, $valor=null)
    {
        $where = '';

        if (!is_null($termo) && !empty($termo) && !is_null($valor) && !empty($valor))
        {
            if ( $termo == 'InscricaoPFId' ){
                $termo = 'tp.InscricaoPFId';
            }
            
            $where = <<<WHERE
                       AND $termo LIKE '$valor%'
                    WHERE;
        }

        $sql = <<<SQL
                SELECT 
                    top 100
                    tp.InscricaoPFId as id
                    ,tp.NomePF as text
                    ,tp.InscricaoPFId
                    ,CAST(tp.DataInscricao AS DATE) AS "DataInscricao"
                    ,tp.NomePF
                    ,CAST(tpcom.DataNascimento AS DATE) AS "DataNascimento"
                    ,tp.StatusCadastralId
                    ,rscp.StatusCadastral 
                    ,tpcom.Cpf
                    ,tpcom.Sexo
                    ,tp.Endereco
                    ,tp.Cep
                    ,rb.Bairro
                    ,rc.Cidade
                    ,rc.Uf
                    ,rdrs.DRS
                FROM tblPF tp 
                INNER JOIN refStatusCadastralPF rscp ON (tp.StatusCadastralId=rscp.StatusCadastralId)
                LEFT JOIN tblPFComplemento tpcom ON (tp.InscricaoPFId=tpcom.InscricaoPFId)
                INNER JOIN refBairro rb ON (tp.BairroId=rb.BairroId)
                INNER JOIN refCidade rc ON (rb.CidadeId=rc.CidadeId)
                INNER JOIN refDRS rdrs ON (rc.DRSId=rdrs.DRSId)

                WHERE
                    1=1 
                    $where
                ORDER BY tp.NomePF ASC;
        SQL;

        return $this->db->query( $sql )->getResultArray();
    }

}
