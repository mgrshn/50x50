<?php

namespace Tests;

require_once __DIR__ . "/../Solution/BigNumbersAdder.php";

use Helpers\NumbersHelper;
use Solution\BigNumberAdder;

/**
 * Тут могли бы быть юнит тесты, но будет самописный.
*/
class Test
{  

    /**
     * Generate 1000 files with big numbers and compare result of summing with 3 methods.
     * 
     * @return int Errors count
     */
    public static function make(): string
    {
        $adderObjects = [];

        $errorsCount = 0;
        
        for ($i = 0; $i < 1000; $i++) {
            $adderObjects[] = new BigNumberAdder(mt_rand(1, 99999999));
            
            if (
                $adderObjects[$i]->firstSolution($adderObjects[$i]->getNumbersArr()) !== 
                $adderObjects[$i]->secondSolution($adderObjects[$i]->getNumbersArr()) ||
                $adderObjects[$i]->secondSolution($adderObjects[$i]->getNumbersArr()) !== 
                $adderObjects[$i]->thirdSolution(NumbersHelper::convertToIntsArr($adderObjects[$i]->getNumbersArr()))
            )
            {
                $errorsCount++;
                break;
            }
        }

        return $errorsCount === 0 ? "Without errors" : "Errors count: {$errorsCount}";
    }
}