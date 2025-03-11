<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaPerfil extends Migration
{
    private $table = 'tb_perfil';

    public function up()
    {
        $this->forge->addField([
            'id_perfil' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'descricao' => [
                'type'       => 'TEXT',
                'null'      => true,
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
        $this->forge->addKey('id_perfil', true);
        $this->forge->addForeignKey('user_created', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_updated', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_deleted', 'tb_usuario', 'id_usuario');
        
        $this->forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);

        $this->db->query("INSERT INTO {$this->table} ( nome, descricao, user_created ) VALUES ( '_Administrador', 'Administrador do Sistema', 1);");

    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
