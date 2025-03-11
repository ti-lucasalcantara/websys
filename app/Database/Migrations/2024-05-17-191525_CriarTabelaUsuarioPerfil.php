<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaUsuarioPerfil extends Migration
{
    private $table = 'tb_usuario_perfil';

    public function up()
    {
        $this->forge->addField([
            'id_usuario_perfil' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_perfil' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'unsigned'    => true,
                'null'        => true,
            ],
            'id_usuario' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'unsigned'    => true,
                'null'        => true,
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
            'ativo' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'null'        => false,
                'default'     => 1
            ],
        ]);
        $this->forge->addKey('id_usuario_perfil', true);
        $this->forge->addForeignKey('user_created', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_updated', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_deleted', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('id_perfil', 'tb_perfil', 'id_perfil');
        $this->forge->addForeignKey('id_usuario', 'tb_usuario', 'id_usuario');
        
        $this->forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);

        $this->db->query("INSERT INTO {$this->table} ( id_perfil, id_usuario, user_created ) VALUES ( 1, 1, 1);");
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}



