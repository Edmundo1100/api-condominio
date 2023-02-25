<?php

namespace Model;

use DB\database;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class TokensModel
{
    private object $database;
    public const TABELA = 'tokens_autorizados ';

    // =================================================================================================
    public function __construct()
    {
        $this->database = new database();
    }

    // =================================================================================================
    // CRIAR NOVO TOKEN
    // =================================================================================================
    public function criarNovoToken($dadosToken)
    {
        if ($dadosToken) {
            $params = [
                ':token' => $dadosToken['token'],
                ':validade' => $dadosToken['validade']
            ];

            $query = 'INSERT INTO ' .
                self::TABELA .
                ' (token, validade) VALUES (:token, :validade)';

            $result = $this->database->EXE_INSERT($query, $params);
            if (!$result) {
                throw new InvalidArgumentException('ERRO AO GERAR TOKEN');
            }
            return true;
        } else {
            throw new InvalidArgumentException('Falta dados do Token');
        }
    }
    // =================================================================================================
    public function validarToken($token)
    {
        $token = str_replace([' ', 'Bearer'], '', $token);

        if ($token) {
            $params = [
                ':token' => $token,
                ':status' => ConstantesGenericasUtil::SIM
            ];

            $query = 'SELECT id FROM ' .
                self::TABELA .
                'WHERE token = :token AND status = :status';

            $result = $this->database->EXE_SELECT($query, $params);
            if (!$result) {
                header("HTTP/1.1 401 Unauthorized");
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_NAO_AUTORIZADO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
        }
    }
}
