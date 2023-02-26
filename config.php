<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ERROR);

//  VALIDACAO DE CABECADO DE ENTRADA ============================================================= 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Headers: content-type');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Origin: *');
    header('HTTP/1.1 200 OK');
    exit;
}

//  CONSTANTES DO BANCO ============================================================= 
define('DB_CHARSET',    'utf8');
define('DB_SERVER',     'localhost');
define('DB_NAME',       'condominio_desenv');
define('DB_USERNAME',   'root');
define('DB_PASSWORD',   '');
// ==================================================================================

/* OUTRAS CONSTANTES */
define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO', 'api-condominio');

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    die('Falha ao carregar autoload!');
}
