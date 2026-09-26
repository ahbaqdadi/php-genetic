<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use InvalidArgumentException;

class DNAGenerator implements DNAGeneratorInterface
{
    public function generate(int $size, array $characters): array
    {
        if ($size < 1) {
            throw new InvalidArgumentException('The DNA size must be at least one.');
        }

        if ($characters === []) {
            throw new InvalidArgumentException('At least one gene is required.');
        }

        $characters = array_values($characters);
        $genese = [];
        for ($i = 0; $i < $size; ++$i) {
            $genese[$i] = $characters[random_int(0, count($characters) - 1)];
        }

        return $genese;
    }
}
