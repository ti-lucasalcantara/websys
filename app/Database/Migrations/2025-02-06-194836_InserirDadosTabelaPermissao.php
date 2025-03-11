<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InserirDadosTabelaPermissao extends Migration
{
    private $table = 'tb_permissao';

    public function up()
    {
        $data = [
            [
                'key' => 'ACL_GERENCIAR_PERFIL',
                'nome' => 'Gerenciar Perfil (ACL)',
                'descricao' => 'cadastrar e/ou remover perfis.',
                'grupo' => 'ADMINISTRATIVO',
                'funcionalidades' => json_encode([]),
                'user_created' => 1,
            ],
            [
                'key' => 'ACL_GERENCIAR_PERMISSOES',
                'nome' => 'Cadastrar Permissões (ACL)',
                'descricao' => 'víncular e/ou desvíncular permissões de perfis.',
                'grupo' => 'ADMINISTRATIVO',
                'funcionalidades' => json_encode([]),
                'user_created' => 1,
            ],
            [
                'key' => 'ACL_GERENCIAR_USUARIOS',
                'nome' => 'Gerenciar Permissões de Usuários (ACL)',
                'descricao' => 'cadastrar e/ou remover permissões para usuários.',
                'grupo' => 'ADMINISTRATIVO',
                'funcionalidades' => json_encode([]),
                'user_created' => 1,
            ],
        ];

        // Inserindo os dados na tabela users
        $this->db->table($this->table)->insertBatch($data);
    }

    public function down()
    {
        $this->db->table($this->table)->whereIn('key', ['ACL_GERENCIAR_PERFIL', 'ACL_GERENCIAR_PERMISSOES', 'ACL_GERENCIAR_USUARIOS'])->delete();
    }
}