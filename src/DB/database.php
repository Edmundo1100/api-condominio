<?php

namespace DB;

use PDO;
use PDOException;
use Util\ConstantesGenericasUtil;

class database
{
    //======================================================================================================
    // SELECT
    //======================================================================================================
    public function EXE_SELECT($query, $parameters = null, $debug = true, $close_connection = true)
    {
        $results = null;
        //connection
        $connection = new PDO(
            'mysql:host=' . DB_SERVER .
                ';dbname=' . DB_NAME .
                ';charset=' . DB_CHARSET,
            DB_USERNAME,
            DB_PASSWORD,
            array(PDO::ATTR_PERSISTENT => true)
        );
        if ($debug) {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        //execution
        try {
            if ($parameters != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($parameters);
                $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
                $results = $gestor->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return false;
        }
        //close connection
        if ($close_connection) {
            $connection = null;
        }
        //returns results
        return $results;
    }

    //======================================================================================================
    // INSERT - retorno o id inserido
    //======================================================================================================
    public function EXE_INSERT($query, $parameters = null, $debug = true, $close_connection = true)
    {
        //connection
        $connection = new PDO(
            'mysql:host=' . DB_SERVER .
                ';dbname=' . DB_NAME .
                ';charset=' . DB_CHARSET,
            DB_USERNAME,
            DB_PASSWORD,
            array(PDO::ATTR_PERSISTENT => true)
        );
        if ($debug) {
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        //execution
        $connection->beginTransaction();
        try {
            if ($parameters != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($parameters);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
            }
            $idInserido = $connection->lastInsertId();
            $connection->commit();
        } catch (PDOException $e) {
            $connection->rollBack();
            return false;
        }
        //close connection
        if ($close_connection) {
            $connection = null;
        }
        return $idInserido;
    }

    //======================================================================================================
    // UPDATE, DELETE
    //======================================================================================================
    public function EXE_UPDATE_DELETE($query, $parameters = null, $debug = true, $close_connection = true)
    {
        //connection
        try {
            $connection = new PDO(
                'mysql:host=' . DB_SERVER .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                DB_USERNAME,
                DB_PASSWORD,
                array(PDO::ATTR_PERSISTENT => true)
            );
            if ($debug) {
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
        //execution
        $connection->beginTransaction();
        try {
            if ($parameters != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($parameters);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
            }
            $linhasDeletadas = $gestor->rowCount();
            $connection->commit();
        } catch (PDOException $e) {
            $connection->rollBack();
            return false;
        }
        //close connection
        if ($close_connection) {
            $connection = null;
        }
        return $linhasDeletadas > 0 ? ConstantesGenericasUtil::MSG_SUCESSO : ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO;
    }
}
