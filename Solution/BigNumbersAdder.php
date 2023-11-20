<?php

namespace Solution;

require_once __DIR__ . "/../Helpers/NumbersHelper.php";
require_once __DIR__ . "/../BigNumbersWorkers/Adder.php";

use Helpers\NumbersHelper;
use BigNumbersWorkers\Adder;

class BigNumberAdder
{
    private array $numbersArr;

    public function __construct($fileName)
    {
        if (!file_exists($fileName))
            NumbersHelper::generateNumbersFile($fileName);
        $this->numbersArr = NumbersHelper::getNumbersAsArrayOfStrings($fileName);
    }

    public function getNumbersArr(): array
    {
        return $this->numbersArr;
    }

    /**
     * Counting sum of big numbers, using https://www.php.net/manual/ru/book.gmp.php
     * 
     * @param array<string> $numbers
     * 
     * @return string
     */
    public function firstSolution(array $numbers): string
    {
        $sum = '0';
        foreach ($numbers as $number) {
            $sum = gmp_strval(gmp_add($sum, $number));
        }

        return $sum;
    }

    /**
     * Counting sum of big numbers, using https://www.php.net/manual/ru/book.bc.php
     * 
     * @param array<string> $strNumbers
     * 
     * @return string
     */
    public function secondSolution(array $numbers): string
    {
        $sum = '0';
        foreach ($numbers as $number) {
            $sum = bcadd($sum, $number);
        }

        return $sum;
    }

    /**
     * Counting sum of big numbers, using BigNumbersWorkers\Adder.
     * 
     * @param array<array<int>> $intNumbers
     * 
     * @return string
     */
    public function thirdSolution(array $numbers)//: string
    {
        $numbers = NumbersHelper::convertToIntsArr($this->getNumbersArr());

        return Adder::sum($numbers);
    }         
}
