<?php

namespace Util;

use InvalidArgumentException;
use JsonException;

class JsonUtil
{

    // ===================================================================================================================
    // ENTRADA
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

    // ===================================================================================================================
    // SAIDA SUCCESS
    // ===================================================================================================================
    public function montarSuccess($retorno)
    {
        $dadosRetorno = [];
        $dadosRetorno[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

        if ((is_array($retorno) && count($retorno) > 0) || strlen($retorno) > 10) {
            $dadosRetorno[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
            $dadosRetorno[ConstantesGenericasUtil::RESPOSTA] = $retorno;
        }
        $this->retornarSuccessJson($dadosRetorno);
    }

    private function retornarSuccessJson($json)
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
    // SAIDA ERROR
    // ===================================================================================================================
    public function montarError($mensagemErro)
    {
        $dadosRetorno = [];
        $dadosRetorno[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;
        $dadosRetorno[ConstantesGenericasUtil::RESPOSTA] = $mensagemErro;
        $this->retornarErroJson($dadosRetorno);
    }
    private function retornarErroJson($json)
    {
        http_response_code(400);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        echo json_encode($json, JSON_THROW_ON_ERROR, 512);
        exit;
    }
}
