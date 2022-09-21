<?php

if (!function_exists('isWindows')) {
    function isWindows()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('clearTerminal')) {
    function clearTerminal()
    {
        if (isWindows()) {
            system('cls');
        } else {
            system('clear');
        }
    }
}