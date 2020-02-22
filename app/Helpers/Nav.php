<?php

namespace App\Helpers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Nav
{
    public static function is($url): bool
    {
        $current = URL::current();

        return $url === $current || Str::startsWith($current, $url . '/');
    }
}
