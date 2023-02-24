<?php

namespace Repository;

use DB\database;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class TokensAutorizadosRepository
{
    private object $database;
    public const TABELA = 'tokens_autorizados ';

    // =================================================================================================
    public function __construct()
    {
        $this->database = new database();
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
