<?php

namespace App\Validation;

class StringRules
{
    public function safe_string(?string $str, ?string &$error = null): bool
    {
        if ($str === null) {
            return true; // allow empty values (use "required" if needed)
        }

        // blacklist certain characters
        if (preg_match('/[<>{};:"\'\\\\\\/]/', $str)) {
            return false;
        }

        return true;
    }
}
