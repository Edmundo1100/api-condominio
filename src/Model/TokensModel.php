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
    public function criarNovoToken($id_usu, $dadosToken)
    {
        if ($dadosToken) {
            $params = [
                ':token' => $dadosToken['token'],
                ':validade' => $dadosToken['validade'],
                ':id_usu' => $id_usu,
            ];

            $query = 'INSERT INTO ' .
                self::TABELA .
                ' (token, validade, id_usu) VALUES (:token, :validade, :id_usu)';

            $result = $this->database->EXEC($query, $params);
            if (!$result) {
                throw new InvalidArgumentException('ERRO AO GERAR TOKEN');
            }
            return true;
        } else {
            throw new InvalidArgumentException('Falta dados do Token');
        }
    }
    // =================================================================================================
    // EDITA TOKEN
    // =================================================================================================
    public function editarToken($id_usu, $dadosToken)
    {
        if ($dadosToken) {
            $params = [
                ':token' => $dadosToken['token'],
                ':validade' => $dadosToken['validade'],
                ':id_usu' => $id_usu,
            ];

            $query = 'UPDATE ' .
            self::TABELA .
            'SET token = :token, validade = :validade 
            where id_usu = :id_usu';

            $result = $this->database->EXEC($query, $params);
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
