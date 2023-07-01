<?php

namespace App\Helpers;

class Helper
{
    public static function gerarCodigoBarras(): string
    {
        $codigoBarras = '';

        for ($i = 0; $i < 44; $i++) {
            $codigoBarras .= mt_rand(0, 9);
        }

        return $codigoBarras;
    }
}
