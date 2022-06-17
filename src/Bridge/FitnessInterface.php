<?php

namespace Ahbaqdadi\PhpGenetic\Bridge;

interface FitnessInterface
{
    public function getFitness(array $target, array $genes) : float;
}