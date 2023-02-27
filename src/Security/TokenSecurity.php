<?php

namespace Security;

// Inclua a biblioteca JWT
require DIR_APP . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

class TokenSecurity
{

    public function gerarToken()
    {
        # // Defina as informações do payload
        $payload = array(
            "key1" => base64_encode(random_bytes(2)),
            "key2" => base64_encode(random_bytes(3)),
        );

        // Defina a chave secreta (deve ser mantida em segredo)
        $key = base64_encode(random_bytes(32));;

        // Defina a data de expiração do token (opcional)
        $exp_time = time() + 3600; // expira em uma hora

        // Crie o token JWT
        $token = JWT::encode($payload, $key, 'HS256');

        // $dadosToken['token'] = $token;
        $dadosToken['token'] = '123';
        $dadosToken['validade'] = $exp_time;

        // Exiba o token gerado
        return $dadosToken;
    }
}
