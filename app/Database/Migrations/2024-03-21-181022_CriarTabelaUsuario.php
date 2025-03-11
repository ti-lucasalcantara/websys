<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaUsuario extends Migration
{
    private $table = 'tb_usuario';

    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'login' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'cargo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'cpf' => [
                'type'       => 'VARCHAR',
                'constraint' => '11',
                'null'       => true,
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'unique'     => true,
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'id_setor' => [
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
                'null'        => true,
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
        $this->forge->addKey('id_usuario', true);
        $this->forge->addForeignKey('user_created', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_updated', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('user_deleted', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('id_setor', 'ref_setor', 'id_setor');
        
        $this->forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);

        $this->db->query("INSERT INTO {$this->table} ( nome, login, id_setor, user_created ) VALUES ( 'Administrador', 'geraladm', 13, 1 );");
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
