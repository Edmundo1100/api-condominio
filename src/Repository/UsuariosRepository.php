<?php

namespace Repository;

use DB\MySQL;

class UsuariosRepository
{
    private object $MySQL;
    const TABELA = 'usuarios';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    // GET POR LOGIN
    // =============================================================================
    public function getRegistroByLogin($login)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE login = :login';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // INSERT
    // =============================================================================
    public function insertUser($login, $senha)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (login, senha) VALUES (:login, :senha)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // UPDATE
    // =============================================================================
    public function updateUser($id, $dados)
    {
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET login = :login, senha = :senha WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':login', $dados['login']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}
