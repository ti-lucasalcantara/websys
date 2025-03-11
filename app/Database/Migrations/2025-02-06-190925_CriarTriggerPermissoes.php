<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTriggerPermissoes extends Migration
{
    public function up()
    {
        // Criando a Trigger
        $triggerInsertSQL = "
            CREATE TRIGGER after_insert_tb_permissao
            AFTER INSERT ON tb_permissao
            FOR EACH ROW
            BEGIN
                INSERT INTO tb_permissao_perfil (id_permissao, id_perfil, user_created)
                VALUES (NEW.id_permissao, 1, 1);
            END;
        ";

        $triggerDeleteSQL = "
            CREATE TRIGGER after_delete_tb_permissao
            AFTER DELETE ON tb_permissao
            FOR EACH ROW
            BEGIN
                DELETE FROM tb_permissao_perfil WHERE id_permissao = OLD.id_permissao;
            END;
        ";

        $this->db->query($triggerInsertSQL);
        $this->db->query($triggerDeleteSQL);

    }

    public function down()
    {
        // Removendo as Triggers
        $this->db->query("DROP TRIGGER IF EXISTS after_insert_tb_permissao");
        $this->db->query("DROP TRIGGER IF EXISTS after_delete_tb_permissao");
    }
    
}
