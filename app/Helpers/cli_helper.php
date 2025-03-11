<?php

if ( ! function_exists('processarFila') ){
    function processarFila($nome, $id_fila=0, $database=0) {
        try {
            if ( PHP_OS == 'WINNT' ) {
                $gsCommand = "start /B php " . FCPATH . "scripts/processQueue.php $nome $id_fila $database > NUL";
                pclose(popen($gsCommand, "r"));

            }else{
                $gsCommand = "php " . FCPATH . "scripts/processQueue.php $nome $id_fila $database > /dev/null 2>&1 &";
                exec($gsCommand);
            }

            return;
            
        } catch (\Throwable $th) {
           throw $th;
        }
    }
}
