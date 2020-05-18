<?php

namespace App\Helpers;

class CodeYoutube
{
    public static function code($url): string
    {
        $parte = explode("=", $url);
        return explode("&", $parte[1])[0];
    }
}
