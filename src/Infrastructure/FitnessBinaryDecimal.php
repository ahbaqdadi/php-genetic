<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;

class FitnessBinaryDecimal implements FitnessInterface
{
    public function getFitness($target = [], $genes = []) : float
    {
        $fit = [];
        foreach ($genes as $key => $value) {
            if($genes[$key] == 1) {
                $fit[$key] = 1;
            } else {
                $fit[$key] = 0;
            }
        }

        return  array_sum($fit);
    }
}