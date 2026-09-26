<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use Ahbaqdadi\PhpGenetic\Bridge\MutatorInterface;
use InvalidArgumentException;

class Mutator implements MutatorInterface
{
    public function __construct(private DNAGeneratorInterface $dnaGenerator)
    {
    }

    public function mutate(array $dna, array $genes): array
    {
        if ($dna === []) {
            throw new InvalidArgumentException('DNA cannot be empty.');
        }

        $index = random_int(0, count($dna) - 1);
        $child = $dna;
        $alternatives = array_values(array_filter(
            $genes,
            static fn (mixed $gene): bool => $gene !== $child[$index]
        ));

        if ($alternatives === []) {
            throw new InvalidArgumentException('The gene pool must contain an alternative value.');
        }

        $child[$index] = $this->dnaGenerator->generate(1, $alternatives)[0];

        return $child;
    }
}
