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
}
