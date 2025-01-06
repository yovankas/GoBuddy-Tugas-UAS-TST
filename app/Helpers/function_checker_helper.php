<?php

if (!function_exists('exec_available')) {
    function exec_available()
    {
        return function_exists('exec') && !in_array('exec', explode(',', ini_get('disable_functions')));
    }
}

if (!function_exists('exec_alternative')) {
    function exec_alternative($command, &$output, &$returnVar)
    {
        if (function_exists('shell_exec')) {
            $output = explode("\n", shell_exec($command . ' 2>&1'));
            $returnVar = 0; // Note: shell_exec doesn't provide a return value
            return true;
        } elseif (function_exists('system')) {
            ob_start();
            $returnVar = system($command . ' 2>&1', $output);
            $output = explode("\n", ob_get_clean());
            return $returnVar !== false;
        } elseif (function_exists('passthru')) {
            ob_start();
            passthru($command . ' 2>&1', $returnVar);
            $output = explode("\n", ob_get_clean());
            return true;
        }
        return false;
    }
}

