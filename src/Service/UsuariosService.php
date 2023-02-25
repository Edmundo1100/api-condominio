<?php

namespace Service;

use InvalidArgumentException;
use Model\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{
    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listarTodos', 'getLogin', 'getId'];
    public const RECURSOS_POST = ['login','cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $request;
    private array $params;
    private object $UsuariosRepository;


    // =============================================================================
    public function __construct($request = [])
    {
        $this->request = $request;
        $this->UsuariosRepository = new UsuariosRepository();
    }

    // =============================================================================
    public function setDadosCorpoRequest($params)
    {
        $this->params = $params;
    }

    // =============================================================================
    // VALIDACAO GET
    // =============================================================================
    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->request['recurso'];
        if (in_array($recurso, self::RECURSOS_GET, true)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    // =============================================================================
    // VALIDACAO DELETE
    // =============================================================================
    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->request['recurso'];
        if (in_array($recurso, self::RECURSOS_DELETE, true)) {
            if ($this->request['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    // =============================================================================
    // VALIDACAO POST
    // =============================================================================
    public function validarPost()
    {
        $retorno = null;
        $recurso = $this->request['recurso'];
        if (in_array($recurso, self::RECURSOS_POST, true)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    // =============================================================================
    // VALIDACAO PUT
    // =============================================================================
    public function validarPut()
    {
        $retorno = null;
        $recurso = $this->request['recurso'];
        if (in_array($recurso, self::RECURSOS_PUT, true)) {
            if ($this->request['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    // =============================================================================
    // LISTAR TODOS
    // =============================================================================
    private function listarTodos()
    {
        return $this->UsuariosRepository->getAllRegistros();
    }
    // =============================================================================
    // GET POR LOGIN
    // =============================================================================
    private function getLogin()
    {
        return $this->UsuariosRepository->getPorLogin($this->request['id']);
    }

    // =============================================================================
    // GET POR ID
    // =============================================================================
    private function getId()
    {
        if ($this->request['id']) {
            return $this->UsuariosRepository->getPorId($this->request['id']);
        }
        throw new InvalidArgumentException('Campo Id faltando');
    }

    // =============================================================================
    // CADASTRAR
    // =============================================================================
    private function cadastrar()
    {
        [$login, $senha] = [$this->params['login'], $this->params['senha']];

        if ($login && $senha) {
            if (count($this->UsuariosRepository->getByLogin($login)) > 0) {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_EXISTENTE);
            }

            $idInserido = $this->UsuariosRepository->insertUser($login, $senha);
            if ($idInserido) {
                return ['id_inserido' => $idInserido];
            }
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
    }

    // =============================================================================
    // DELETAR
    // =============================================================================
    private function deletar()
    {
        return $this->UsuariosRepository->delete($this->request['id']);
    }

    // =============================================================================
    // ATUALIZAR
    // =============================================================================
    private function atualizar()
    {
        if ($this->UsuariosRepository->updateUser($this->request['id'], $this->params) > 0) {
            // $this->UsuariosRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }

    // =============================================================================
    // LOGAR
    // =============================================================================
    private function login()
    {
        $this->params;
        if ($this->request['id']) {
            return $this->UsuariosRepository->getPorId($this->request['id']);
        }
        throw new InvalidArgumentException('Campo Id faltando');
    }
}
