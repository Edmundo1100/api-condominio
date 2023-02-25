<?php

namespace Util;

use InvalidArgumentException;
use JsonException;

class JsonUtil
{

    // ===================================================================================================================
    public function processarArrayParaRetornar($retorno)
    {
        $dados = [];
        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

        if ((is_array($retorno) && count($retorno) > 0) || strlen($retorno) > 10) {
            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
            $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
        }

        $this->retornarJson($dados);
    }

    // ===================================================================================================================
    private function retornarJson($json)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        echo json_encode($json, JSON_THROW_ON_ERROR, 1024);
        exit;
    }

    // ===================================================================================================================
    public static function tratarParametros()
    {
        try {
            $params = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
        }
        if (is_array($params) && count($params) > 0) {
            return $params;
        }
    }
}
