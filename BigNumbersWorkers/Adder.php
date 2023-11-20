<?php

namespace BigNumbersWorkers;

class Adder
{
    /**
     * Counting sum of big nums in column with 5 digits.
     * @param array<array<int>> $intNumbers
     * 
     * @return string
     */
    public static function sum(array $numbers)//: string
    {
        $result = [];
        $overflow = 0;
        $sumLimit = 100000;
        $maxDigits = 5;
        for ($i = 9; $i >= 0; $i--) {
            $sum = 0;

            foreach ($numbers as $number) {
                $sum += $number[$i] + $overflow;
                $overflow = 0;
            }

            while ($sum >= $sumLimit) {
                $sum -= $sumLimit;
                $overflow++;
            }

            $result[] = $sum;

            if ($sum <= 9999) {
                $result = array_merge($result, array_fill(count($result), $maxDigits - strlen($sum), 0));
            }

            if ($i === 0) {
            $result[] = $overflow;
            }
        }

        return implode(array_reverse($result));
    }
}