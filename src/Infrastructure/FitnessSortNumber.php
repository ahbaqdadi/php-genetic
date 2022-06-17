<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;

class FitnessSortNumber implements FitnessInterface
{
    public function getFitness($target = [], $genes = []) : float
    {
        $fitness = 1;

        foreach (range(1, count($genes) - 1) as $key => $value) {
            if ($genes[$value] > $genes[$value - 1]) {
                $fitness += 1;
            } 
        }

        return  $fitness;
    }
}