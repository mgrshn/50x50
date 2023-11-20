<?php

namespace Helpers;

class NumbersHelper
{
    /**
     * Generating file with 50 50digits numbers as a strings
     * 
     * @param strig $fileName
     * 
     * @return void
     */
    public static function generateNumbersFile(string $fileName): void
    {
        $numbers = [];
        for ($i = 0; $i < 50; $i++) {
            $numberStr = '';
            while (strlen($numberStr) !== 50) {
                $numberStr .= mt_rand(10000, 99999);
            }
            $numbers[] = $numberStr;
        }
        file_put_contents("$fileName", implode("\n", $numbers));
    }
    
    /**
     * Read file and return array with string nums
     * 
     * @param string $fileName
     * 
     * @return string[] array
     */
    public static function getNumbersAsArrayOfStrings(string $fileName): array
    {
        return explode("\n", file_get_contents($fileName));
    }

    /**
     * Convreting array with string in array with arrays with ints.
     * 
     * @param string[] $array
     * 
     * @return array
     */
    public static function convertToIntsArr(array $array): array
    {
        return array_reduce($array, function ($acc, $elem) {
            $numbersArrWithInts = array_map(fn ($digit) => intval($digit), str_split($elem, 5));
            $acc[] = $numbersArrWithInts;
            return $acc;
        }, []);
    }
}