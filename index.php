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
    $JsonUtil->montarSuccess($retorno);
} catch (InvalidArgumentException | DomainException | PDOException | Exception $exception) {
    $JsonUtil = new JsonUtil();
    $JsonUtil->montarError($exception->getMessage());
    // echo json_encode([
    //     ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
    //     ConstantesGenericasUtil::RESPOSTA => $exception->getMessage()
    // ], JSON_THROW_ON_ERROR, 512);
    // exit;
}
