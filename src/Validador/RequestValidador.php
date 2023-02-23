<?php

namespace Validador;


class RequestValidador
{

    private $request;

    public function __construct($request)
    {
        $this->$request = $request;
    }
}
