<?php

namespace Util;

class RotasUtil
{
    // ===================================================================================================================
    public static function getRotas()
    {
        $urls = self::getUrls();
        $request['rota'] = strtoupper($urls[0]);
        $request['recurso'] = $urls[1] ?? null;
        $request['id'] = $urls[2] ?? null;

        //VIA WEB OU POSTMAN
        if ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) { 
            $request['metodo'] = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'];
        } else {
            $request['metodo'] = $_SERVER['REQUEST_METHOD'];
        }
        return $request;
    }

    // ===================================================================================================================
    public static function getUrls()
    {
        var_dump($_SERVER);
        $uri = str_replace('/' . DIR_PROJETO, '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }
}
