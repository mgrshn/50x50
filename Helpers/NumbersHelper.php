<?php

namespace Helpers;

class NumbersHelper
{
    public static function generateNumbersFile(string $fileName): void
    {
        $numbers = [];
        for ($i = 0; $i < 50; $i++) {
            $numberStr = '';
            while (strlen($numberStr) !== 50) {
                //$numberStr .= mt_rand(10000, 99999);
                $numberStr .= mt_rand(22222, 22222);
            }
            $numbers[] = $numberStr;
        }
        file_put_contents("$fileName", implode("\n", $numbers));
    }

    public static function getNumbersAsArrayOfStrings(string $fileName): array
    {
        return explode("\n", file_get_contents($fileName));
    }
}