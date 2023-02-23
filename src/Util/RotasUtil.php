<?php

namespace Util;

class RotasUtil
{
    public static function getRotas()
    {
        $urls = self::getUrls();
    }

    public static function getUrls()
    {
        echo '<pre>';
        var_dump($_SERVER);
    }
}
