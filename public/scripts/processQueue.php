#!/usr/bin/env php
<?php
ini_set('memory_limit', '256M');

define('FCPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

require_once $paths->systemDirectory . '/bootstrap.php';

// Carregar o .env
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(FCPATH . '../');
$dotenv->load();

defined('ENVIRONMENT') || define('ENVIRONMENT', getenv('CI_ENVIRONMENT'));
define('CI_DEBUG', ENVIRONMENT !== 'production');


$nome = $argv[1] ?? '';
$id_fila = $argv[2] ?? 0;
$database = $argv[3] ?? 0;

$fila = service('fila', $database);

$fila->process($nome, $id_fila, $database);

echo "Processo concluído com sucesso!\n"; 