<?php

namespace Solution;

require_once __DIR__ . "/../Helpers/NumbersHelper.php";

use Helpers\NumbersHelper;

class BigNumberAdder
{
    private array $numbersArr;

    public function __construct($fileName)
    {
        if (!file_exists($fileName))
            NumbersHelper::generateNumbersFile($fileName);
        $this->numbersArr = NumbersHelper::getNumbersAsArrayOfStrings($fileName);
    }

    public function getNumbersArr()
    {
        return $this->numbersArr;
    }

    /**
     * Counting sum of big numbers, using https://www.php.net/manual/ru/book.gmp.php
     * 
     * @return string
     */
    public function firstSolution(): string
    {
        $sum = '0';
        $numbers = $this->getNumbersArr();
        foreach ($numbers as $number) {
            $sum = gmp_strval(gmp_add($sum, $number));
        }

        return $sum;
    }

    /**
     * Counting sum of big numbers, using https://www.php.net/manual/ru/book.bc.php
     * 
     * @return string
     */
    public function secondSolution(): string
    {
        $sum = '0';
        $numbers = $this->getNumbersArr();
        foreach ($numbers as $number) {
            $sum = bcadd($sum, $number);
        }

        return $sum;
    }

    /**
     * Counting sum of big numbers, using bad bycicle:).
     * 
     * На самом деле, это прям кринж, мне за этот код стыдно, хотел выпендриться и считать сразу по несколько разрядов
     * и в итоге запутался к чертям, надо было просто в столбик считать попарно, хотя итераций в таком случае будет больше в 10 раз.
     * 
     * Но, этот франкинштейн считает корректно
     */
    public function thirdSolution(): string
    {
        $numbers = $this->getNumbersArr();
        $numbers = array_reduce($numbers, function ($acc, $number) {
            $numbersArrWithStrings = str_split($number, 5);
            $numbersArrWithInts = [];
            foreach ($numbersArrWithStrings as $digit) {
                $numbersArrWithInts[] = intval($digit);
            }
            $acc[] = $numbersArrWithInts;
            return $acc;
        }, []);

        $result = [];
        $overflow = 0;
        for ($i = 9; $i >= 0; $i--) {
            $sum = 0;

            foreach ($numbers as $number) {
                $sum += $number[$i] + $overflow;
                $overflow = 0;
            }
            
            while ($sum >= 100000) {
                $sum -= 100000;
                $overflow++;
            }

            $result[] = $sum;

            if ($sum <= 9999 && $sum >= 1000) {
                array_push($result, 0);
                }
            if ($sum <= 999 && $sum >= 100) {
                array_push($result, 0, 0);
                }
            if ($sum <= 99 && $sum >= 10) {
                array_push($result, 0, 0, 0);
                }
            if ($sum <= 9 && $sum >= 0) {
                array_push($result, 0, 0, 0, 0);
                }

            if ($i === 0) {
             $result[] = $overflow;
            }
        }
        return implode(array_reverse($result));
    }
    /**
     * For tests.
     * 
     * Genereta 1000 files with big numbers and compare result of summing with 3 methods.
     * 
     * @return int Errors count
     */
    public static function test(): int
    {
        $adderObjects = [];

        $errorsCount = 0;
        
        for ($i = 0; $i < 1000; $i++) {
            $adderObjects[] = new BigNumberAdder(mt_rand(1, 99999999));
            if (
                $adderObjects[$i]->firstSolution() !== $adderObjects[$i]->secondSolution() ||
                $adderObjects[$i]->secondSolution() !== $adderObjects[$i]->thirdSolution()
            )
            {
                $errorsCount++;
            }
        }

        return $errorsCount;
    }
}


var_dump(BigNumberAdder::test());