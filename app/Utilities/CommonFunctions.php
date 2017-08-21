<?php
namespace App\Utilities;

class CommonFunctions {

    public function startswith($haystack, $needle) {
        $haystack = strtolower($haystack);
        $needle = strtolower($needle);

        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    public function endsWith($haystack, $needle) {
        $haystack = strtolower($haystack);
        $needle = strtolower($needle);

        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
