<?php

namespace Control;

use InvalidArgumentException;
use Model\TokensAutorizadosRepository;
use Service\UsuariosService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestControl
{

    private array $request;
    private array $params;
    private object $TokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';

    public function __construct($request = [])
    {
        $this->TokensAutorizadosRepository = new TokensAutorizadosRepository();
        $this->request = $request;
    }

    // =============================================================================
    public function processarRequest()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
            $retorno =  $this->direcionarRequest();
        }
        return $retorno;
    }

    // =============================================================================
    private function direcionarRequest()
    {
        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->params = JsonUtil::tratarPametros();
        }

        if ($this->request['recurso'] !== 'login') {
            $this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        }
        $metodo = $this->request['metodo'];
        return $this->$metodo();
    }

    // =============================================================================
    // GET
    // =============================================================================
    public function get()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarGet();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    // =============================================================================
    // POST
    // =============================================================================

    private function post()
    {
        $retorno = null;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->params);
                    $retorno = $UsuariosService->validarPost();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
            }
            return $retorno;
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
    }

    // =============================================================================
    // PUT
    // =============================================================================
    private function put()
    {
        $retorno = null;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->params);
                    $retorno = $UsuariosService->validarPut();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
            }
            return $retorno;
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
    }

    // =============================================================================
    // DELETE
    // =============================================================================
    private function delete()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarDelete();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }
}
