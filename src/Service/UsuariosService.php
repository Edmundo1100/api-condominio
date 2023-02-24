<?php

namespace Service;

use InvalidArgumentException;
use Model\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{
    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listarTodos', 'getLogin', 'getId'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    private object $UsuariosRepository;


    // =============================================================================
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->UsuariosRepository = new UsuariosRepository();
    }

    // =============================================================================
    public function setDadosCorpoRequest($dadosCorpoRequest)
    {
        $this->dadosCorpoRequest = $dadosCorpoRequest;
    }

    // =============================================================================
    // VALIDACAO GET
    // =============================================================================
    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
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
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_DELETE, true)) {
            if ($this->dados['id'] > 0) {
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
        $recurso = $this->dados['recurso'];
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
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_PUT, true)) {
            if ($this->dados['id'] > 0) {
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
        return $this->UsuariosRepository->getPorLogin($this->dados['id']);
    }

    // =============================================================================
    // GET POR ID
    // =============================================================================
    private function getId()
    {
        if($this->dados['id']){
            return $this->UsuariosRepository->getPorId($this->dados['id']);
        }
        throw new InvalidArgumentException('Campo Id faltando');
    }

    // =============================================================================
    // CADASTRAR
    // =============================================================================
    private function cadastrar()
    {
        [$login, $senha] = [$this->dadosCorpoRequest['login'], $this->dadosCorpoRequest['senha']];

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
        return $this->UsuariosRepository->delete($this->dados['id']);
    }

    // =============================================================================
    // ATUALIZAR
    // =============================================================================
    private function atualizar()
    {
        if ($this->UsuariosRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            // $this->UsuariosRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }
}
