<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use Ahbaqdadi\PhpGenetic\Bridge\MutatorInterface;

class Mutator implements MutatorInterface
{
    public function __construct(private DNAGeneratorInterface $dnaGenerator)
    {
        
    }

    public function mutate(array $dna ,array $genes): array
    {
        $index = rand(0, count($dna) - 1);
        $child = $dna;
        $newGene = $this->dnaGenerator->generate(1, $genes)[0];

        if ($newGene !== $child[$index]) { 
            $child[$index] = $newGene;
        } else {
            return $this->mutate($dna, $genes);
        }
            
        return $child;
    }
}