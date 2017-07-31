<?php

namespace FrontFiles\Utility;

class Helper
{
    /**
     * Generates a pseudo-random alpha-numeric string.
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomAlphaNumericString(int $length = 8) : string
    {
        $output = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($chars) - 1;

        for($i = 0; $i < $length; $i++)
            $output .= $chars[random_int(0, $max)];

        return $output;
    }
}