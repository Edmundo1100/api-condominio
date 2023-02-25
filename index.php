<?php

require_once 'config.php';

use Control\RequestControl;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;

try {
    $RequestControl = new RequestControl(RotasUtil::getRotas());
    $retorno = $RequestControl->processarRequest();

    $JsonUtil = new JsonUtil();
    $JsonUtil->processarArrayParaRetornar($retorno);
} catch (Exception $exception) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    exit;
}
