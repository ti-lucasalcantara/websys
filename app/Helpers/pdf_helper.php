<?php

use Spipu\Html2Pdf\Html2Pdf;

if ( ! function_exists('gerarPDF') ){
    function gerarPDF( 
        $html='', 
        $fileName='', 
        $fullPath='', 
        $header_pdf=[
            'orientation' => 'P', 
            'format' => 'A4',
            'lang' => 'pt', 
            'unicode' => true,
            'encoding'=> 'UTF-8',
            'margins' => array(5, 5, 5, 8), 
            'pdfa' => false 
        ] 
    ) {
       
        try {

            if (!is_dir($fullPath)) {
                if (!mkdir($fullPath, 0775, true)) {
                    return json_encode(getMessageFail('toast', ['text' => 'Falha ao criar pasta: '.$fullPath]));
                }
            }

            if (is_null($header_pdf)){
                $header_pdf=[
                    'orientation' => 'P', 
                    'format' => 'A4',
                    'lang' => 'pt', 
                    'unicode' => true,
                    'encoding'=> 'UTF-8',
                    'margins' => array(5, 5, 5, 8), 
                    'pdfa' => false 
                ];
            }

            $output_file = $fullPath . $fileName;

            $html = str_replace("./assets/", FCPATH."assets/", $html);

            $html2pdf = new Html2Pdf($header_pdf['orientation'], $header_pdf['format'], $header_pdf['lang'], $header_pdf['unicode'], $header_pdf['encoding'], $header_pdf['margins'], $header_pdf['pdfa']);
            $html2pdf->addFont('LibreBarcode39', '', 'assets/fonts/LibreBarcode39Text-Regular.php');
            $html2pdf->writeHTML($html);
            $html2pdf->output($output_file, 'F');

            return $output_file;

        } catch (\Throwable $th) {
           throw $th;
        }
    }
}



if ( ! function_exists('mergePDF') ){
    function mergePDF( $input_files=array(), $output_file=''  ) {
       
        try {
            if ( PHP_OS == 'WINNT' ) {
                $command = 'gswin64c';
            }else{
                $command = 'gs';
            }
    
            $gsCommand = $command.' -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=' . escapeshellarg($output_file);
    
            // Adiciona cada arquivo PDF ao comando
            foreach ($input_files as $file) {
                $gsCommand .= ' ' . escapeshellarg($file);
            }
    
            exec($gsCommand, $output, $return_var);
    
            // 0 - sem erros
            // 1 - com erros
            return !$return_var;

        } catch (\Throwable $th) {
           throw $th;
        }
    }
}
