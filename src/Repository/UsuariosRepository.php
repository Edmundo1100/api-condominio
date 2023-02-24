<?php

namespace Repository;

use DB\database;

class UsuariosRepository
{
    private object $database;
    const TABELA = 'usuarios ';

    public function __construct()
    {
        $this->database = new database();
    }

    // GET POR LOGIN
    // =============================================================================
    public function getRegistroByLogin($login)
    {
        $params = [
            ':login' => $login,
        ];

        $query = 'SELECT * FROM ' .
            self::TABELA .
            ' WHERE login = :login';

        $result = $this->database->EXE_SELECT($query, $params);
        return $result;
    }

    // INSERT
    // =============================================================================
    public function insertUser($login, $senha)
    {

        $params = [
            ':login' => $login,
            ':senha' => $senha,
        ];

        $query = 'INSERT INTO ' .
            self::TABELA .
            ' (login, senha) VALUES (:login, :senha)';

        $result = $this->database->EXE_INSERT($query, $params);
        return $result;
    }

    // UPDATE
    // =============================================================================
    public function updateUser($id, $dados)
    {
        $params = [
            ':id' => $id,
            ':login' => $dados['login'],
            ':senha' => $dados['senha'],
        ];
        $query = 'UPDATE ' .
            self::TABELA .
            'SET login = :login, senha = :senha 
            where id = :id';

        $result = $this->database->EXE_NON_QUERY($query, $params);
        return $result;
    }

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
}
