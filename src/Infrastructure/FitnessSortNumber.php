<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;

class FitnessSortNumber implements FitnessInterface
{
    public function getFitness(array $target, array $genes): float
    {
        $fitness = $genes === [] ? 0 : 1;
        $geneCount = count($genes);

        for ($index = 1; $index < $geneCount; ++$index) {
            if ($genes[$index] > $genes[$index - 1]) {
                ++$fitness;
            }
        }

        return (float) $fitness;
    }
}
