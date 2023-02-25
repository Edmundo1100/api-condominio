<?php

namespace Service;

use Exception;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use Model\TokensModel;
use Model\UsuariosModel;
use Security\TokenSecurity;
use Util\ConstantesGenericasUtil;

class UsuariosService
{
    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listarTodos', 'getUsuario', 'getId'];
    public const RECURSOS_POST = ['login', 'cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $request;
    private array $params;
    private object $UsuariosModel;


    // =============================================================================
    public function __construct($request = [])
    {
        $this->request = $request;
        $this->UsuariosModel = new UsuariosModel();
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
        return $this->UsuariosModel->getAllRegistros();
    }
    // =============================================================================
    // GET POR USUARIO
    // =============================================================================
    private function getUsuario()
    {
        return $this->UsuariosModel->getPorUsuario($this->request['id']);
    }

    // =============================================================================
    // GET POR ID
    // =============================================================================
    private function getId()
    {
        if ($this->request['id']) {
            return $this->UsuariosModel->getPorId($this->request['id']);
        }
        throw new InvalidArgumentException('Campo Id faltando');
    }

    // =============================================================================
    // CADASTRAR
    // =============================================================================
    private function cadastrar()
    {
        [$usuario, $senha] = [$this->params['usuario'], $this->params['senha']];

        if ($usuario && $senha) {
            if (count($this->UsuariosModel->getByUsuario($usuario)) > 0) {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_EXISTENTE);
            }

            $idInserido = $this->UsuariosModel->insertUser($usuario, $senha);
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
        return $this->UsuariosModel->delete($this->request['id']);
    }

    // =============================================================================
    // ATUALIZAR
    // =============================================================================
    private function atualizar()
    {
        if ($this->UsuariosModel->updateUser($this->request['id'], $this->params) > 0) {
            // $this->UsuariosModel->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->UsuariosModel->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }

    // =============================================================================
    // LOGAR
    // =============================================================================
    private function login()
    {
        $this->params;
        if ($this->params['usuario'] && $this->params['senha']) {
            $sucess = $this->UsuariosModel->logar($this->params);
            if ($sucess) {
                return $this->gerarToken();
            } else {
                throw new SignatureInvalidException('USUARIO OU SENHA INCORRETOS');
            }
        }
        throw new InvalidArgumentException('Faltando campos de Login e Senha');
    }
    private function gerarToken()
    {
        $geradorToken = new TokenSecurity();
        $Dadostoken = $geradorToken->gerarToken();
        $tokensModel = new TokensModel();
        $tokenSalvo = $tokensModel->criarNovoToken($Dadostoken);
        if ($tokenSalvo) {
            return  array("token" => $Dadostoken['token']);
        }
        throw new Exception('ERRO AO SALVAR TOKEN');
    }
}
