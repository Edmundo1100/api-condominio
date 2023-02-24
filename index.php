<?php

// require_once 'autoload.php';
require_once 'config.php';

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;
use Control\RequestValidator;

try {
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();

    $JsonUtil = new JsonUtil();
    $JsonUtil->processarArrayParaRetornar($retorno);

} catch (Exception $exception) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    exit;
}

