<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaPermissao extends Migration
{
    private $table = 'tb_permissao';

    public function up()
    {
        $this->forge->addField([
            'id_permissao' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'descricao' => [
                'type'       => 'TEXT',
                'null'      => true,
            ],
            'funcionalidades' => [
                'type'       => 'JSON',
                'null'       => true,
            ],
           'grupo' => [
                'type'       => "ENUM('DASHBOARD', 'ATENDIMENTO', 'INSCRICAO/REGISTRO', 'COBRANCA', 'FISCALIZACAO', 'ETICA', 'ADVOCACIA', 'ADMINISTRATIVO')",
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
            ],
            'user_created' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'unsigned'    => true,
            ],
            'user_updated' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'unsigned'    => true,
                'null'        => true,
            ],
            'user_deleted' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'unsigned'    => true,
                'null'        => true,
            ],
        ]);
        $this->forge->addKey('id_permissao', true);
        $this->forge->addForeignKey('user_created', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_updated', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_deleted', 'tb_usuario', 'id_usuario');
        
        $this->forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
