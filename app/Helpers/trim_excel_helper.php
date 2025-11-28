<?php

if (!function_exists('trim_excel')) {
    function trim_excel($value)
    {
        $trimmed = trim($value);
        return $trimmed === '' ? null : $trimmed;
    }
}
