<?php

require_once 'autoload.php';

use Util\RotasUtil;
use Validador\RequestValidador;

try {
    $RequestValidator = new RequestValidador(RotasUtil::getRotas());
} catch (Exception $exception) {
    echo $exception->getMessage();
}
