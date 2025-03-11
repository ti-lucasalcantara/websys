<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaRefSetor extends Migration
{
    private $table = 'ref_setor';

    public function up()
    {
        $this->forge->addField([
            'id_setor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'setor' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'gerencia' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'sigla' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'icone' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'ativo' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'null'        => false,
                'default'     => 1
            ],
        ]);
        $this->forge->addKey('id_setor', true);
        $this->forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);

        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Superintendência', 'Superintendência', 'STA', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Coordenação de Gabinete da Presidência e Diretoria', 'Superintendência', 'STA', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Controladoria Geral', 'Controladoria Geral', 'CG', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Assessorias', 'Assessorias', 'ASS', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Procuradoria-Geral', 'Procuradoria-Geral', 'PG', 'fa-gavel');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Coordenação de Recuperação de Crédito', 'Procuradoria-Geral', 'COB', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Registro', 'Gerência de Atendimento, Inscrição e Registro', 'GAIR', 'fa-users');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Coordenação de Atendimento ao Público', 'Gerência de Atendimento, Inscrição e Registro', 'GAIR', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Fiscalização', 'Gerência de Fiscalização', 'GS', 'fa-search');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Ética Profissional', 'Gerência de Orientação e Ética Profissional', 'GOE', 'fa-address-book-o');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Financeiro', 'Gerência de Orçamento, Finança e Contabilidade', 'GOFC', 'fa-usd');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'RH', 'Gerência de Desenvolvimento Organizacional', 'GDO', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Informática', 'Gerência de Tecnologia da Informação', 'GTIN', '');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Assessoria Técnica', 'Gerência Técnica e Científica', 'GTC', 'fa-flask');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Comunicação', 'Gerência de Comunicação e Marketing', 'GCM', 'fa-user-circle-o');");
        $this->db->query("INSERT INTO {$this->table} ( setor, gerencia, sigla, icone ) VALUES ( 'Infraestrutura', 'Gerência Administrativa', 'GA', '');");
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
