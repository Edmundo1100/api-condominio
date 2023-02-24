<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ERROR);


/* CONSTANTES DO BANCO 1 ========================================================*/ 
define('HOST',     'localhost');
define('BANCO',    'producao');
define('USUARIO',  'root');
define('SENHA',    '');

/* CONSTANTES DO BANCO 2 ========================================================*/ 
define('DB_CHARSET',    'utf8');
define('DB_SERVER',     'localhost');
define('DB_NAME',       'producao');
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
