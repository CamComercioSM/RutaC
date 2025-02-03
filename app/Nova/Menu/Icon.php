<?php

namespace App\Nova\Menu;

class Icon {

    private static $svg = '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">%path%</svg>';
    private static $base = '<path stroke="var(--sidebar-icon)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />';
    private static $world = '<path stroke="var(--sidebar-icon)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
    private static $manage      = '<path stroke="var(--sidebar-icon)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>';

    public static function Base() {
        return str_replace('%path', self::$base, self::$svg);
    }

    public static function World() {
        return str_replace('%path', self::$world, self::$svg);
    }

    public static function Manage(){
        return str_replace('%path', self::$manage, self::$svg);
    }
}
