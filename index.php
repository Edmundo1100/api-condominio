<?php

// require_once 'autoload.php';
require_once 'config.php';

use Util\RotasUtil;
use Validator\RequestValidator;

try {
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
