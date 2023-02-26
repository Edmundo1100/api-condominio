<?php

namespace Model;

use DB\database;
use InvalidArgumentException;

class UsuariosModel
{
    private object $database;
    const TABELA = 'usuarios ';

    // =============================================================================
    public function __construct()
    {
        $this->database = new database();
    }

    // =============================================================================
    // LOGAR
    // =============================================================================
    public function logar($params)
    {
        $params = [
            ':usuario' => $params['usuario'],
            ':senha' => $params['senha'],
        ];

        $query = 'SELECT * FROM ' .
            self::TABELA .
            ' WHERE usuario = :usuario and senha = :senha';

        $result = $this->database->EXEC($query, $params);
        if (count($result) === 1) {
            return $result[0]['id_usu'];
        }
        return false;
    }
    // =============================================================================
    // GET POR USUARIO
    // =============================================================================
    public function getPorUsuario($usuario)
    {
        $params = [
            ':usuario' => $usuario,
        ];

        $query = 'SELECT * FROM ' .
            self::TABELA .
            ' WHERE usuario = :usuario';

        $result = $this->database->EXE($query, $params);
        return $result;
    }
    // =============================================================================
    // GET POR ID
    // =============================================================================
    public function getPorId($id)
    {
        $params = [
            ':id' => $id,
        ];

        $query = 'SELECT * FROM ' .
            self::TABELA .
            ' WHERE id = :id';

        $result = $this->database->EXE_SELECT($query, $params);
        return $result;
    }

    // =============================================================================
    // GET TODOS
    // =============================================================================
    public function getAllRegistros()
    {
        $query = 'SELECT * FROM ' . self::TABELA;
        $result = $this->database->EXE_SELECT($query);
        return $result;
    }

    // =============================================================================
    // INSERT
    // =============================================================================
    public function insertUser($usuario, $senha)
    {
        $params = [
            ':usuario' => $usuario,
            ':senha' => $senha,
        ];
        $query = 'INSERT INTO ' .
            self::TABELA .
            ' (usuario, senha) VALUES (:usuario, :senha)';

        $result = $this->database->EXE_INSERT($query, $params);
        return $result;
    }

    // =============================================================================
    // UPDATE
    // =============================================================================
    public function updateUser($id, $dados)
    {
        $params = [
            ':id' => $id,
            ':usuario' => $dados['usuario'],
            ':senha' => $dados['senha'],
        ];
        $query = 'UPDATE ' .
            self::TABELA .
            'SET usuario = :usuario, senha = :senha 
            where id = :id';

        $result = $this->database->EXE_NON_QUERY($query, $params);
        return $result;
    }

    // =============================================================================
    // DELETE
    // =============================================================================
    public function delete($id)
    {
        $params = [
            ':id' => $id
        ];
        $query = 'DELETE FROM ' .
            self::TABELA .
            'WHERE id = :id';

        $result = $this->database->EXE_NON_QUERY($query, $params);
        return $result;
    }
    // =================================================================================================
    // USUARIO TEM TOKEN
    // =================================================================================================
    public function usuarioPossuiToken($id_usu)
    {
        if ($id_usu) {
            $params = [
                ':id_usu' => $id_usu,
            ];

            $query = 'SELECT * FROM ' .
                self::TABELA .
                'INNER JOIN tokens_autorizados ' .
                'ON usuarios.id_usu = tokens_autorizados.id_usu ' .
                'WHERE usuarios.id_usu = :id_usu';

            $result = $this->database->EXEC($query, $params);
            if (count($result) === 1) {
                return $result[0]['id_token'];
            }
            return false;
        } else {
            throw new InvalidArgumentException('Erro buscar token do usuario!');
        }
    }
}
