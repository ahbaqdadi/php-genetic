<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;

class FitnessString implements FitnessInterface
{
    public function getFitness(array $target, array $genes) : float
    {
        $fit = [];
        foreach ($genes as $key => $value) {
            if ($target[$key] == $value) {
                $fit[$key] = 1;
            } else {
                $fit[$key] = 0;
            }
        }

        return  array_sum($fit);
    }
}