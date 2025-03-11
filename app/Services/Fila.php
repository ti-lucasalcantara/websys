<?php

namespace App\Services;

use CodeIgniter\Config\BaseService;
use Predis\Client;

use App\Models\TbNotificacoes;
use App\Models\TbOficios;
use App\Models\TbFilas;

class Fila extends BaseService
{
    public $redis;

    public function __construct($database=null)
    {
        $config = config('Redis');
       
        if(is_null($database)){
           $database = $config->database;
        }

        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => $config->host,
            'port'   => $config->port,
            'password' => $config->password,
            'database' => $database,
        ]);
    }


    public function add($fila, $dados) 
    {
        $this->redis->rpush($fila, json_encode($dados));
    }
    
    function del($fila)
    {
        return $this->redis->del($fila);
    }

    public function progress()
    {
        $progress = $this->redis->get('progress') ?: 0;
       
        return json_encode(['progress' => $progress]);
    }
    
    private function get($fila)
    {
        $dados = $this->redis->lpop($fila);
        return $dados ? json_decode($dados, true) : null;
    }

    public function process($queue, $id_fila, $redis_database=0) 
    {
        $TbFilas = new TbFilas();
        $qtd_concluido=0;
        $id_concluido=[];
        while (true) {
            $task = $this->get($queue);
            if ($task) {

                switch ($queue) {
                    
                    case 'fila_teste':
                        $html     = $task['html'];
                        $fileName = 'teste_'.$task['id'].'.pdf';
                        $fullPath = FCPATH . 'pdf/'.date('Y').'/notificacaoes/pj/';
                        break;

                    case 'gerar_pdf':

                        $html     = $task['html'];
                        $fileName = $task['file_name'].'db.pdf';
                        $fullPath = $task['base_path'] . $task['full_path'];
                        
                        $header_pdf = $task['header_pdf'] ?? null;

                        gerarPDF($html, $fileName, $fullPath, $header_pdf);

                        $url_documento = env('app.baseURL').$task['full_path'].$fileName;

                        $id_notificacao = $task['id_notificacao'] ?? null;
                        $id_oficio = $task['id_oficio'] ?? null;

                        if ( isset($id_notificacao) && !empty($id_notificacao) && isset($task['campo_update']) && !empty($task['campo_update']) ){
                            (new TbNotificacoes())->update($id_notificacao, [$task['campo_update'] => $url_documento]);
                            $id_update = $id_notificacao;
                        }

                        if ( isset($id_oficio) && !empty($id_oficio) && isset($task['campo_update']) && !empty($task['campo_update']) ){
                            (new TbOficios())->update($id_oficio, [$task['campo_update'] => $url_documento]);
                            $id_update = $id_oficio;
                        }

                        $id_concluido[] = $id_update;

                        $TbFilas->set('qtd_concluido', 'qtd_concluido + 1', false)->where('id_fila', $id_fila)->update();
                        $TbFilas->set('id_concluido', "JSON_ARRAY_APPEND(id_concluido, '$', '$id_update')", false)->where('redis_db', $redis_database)->where('id_fila', $id_fila)->update();

                        $qtd_concluido++;

                        break;
                    
                    default:
                        break;
                }

            }else{
                break;
            } 
        }
        
        $TbFilas->update($id_fila, ['data_fim' => date('Y-m-d H:i:s'), 'qtd_concluido' => $qtd_concluido,  'redis_db' => $redis_database, 'id_concluido' => json_encode($id_concluido)]);

        return; 
    }

}