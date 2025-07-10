<?php

namespace App\Helpers;

class CodeGenerator
{
    public static function generate()
    {
        $intervalInSeconds = 30;
        $currentTime = now()->timestamp;
        $seed = floor($currentTime / ($intervalInSeconds));

        mt_srand($seed);
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
}
