<?php

namespace Ahbaqdadi\PhpGenetic\Infrastructure;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;

class DNAGenerator implements DNAGeneratorInterface
{
    public function generate(int $size, array $characters): array
    {
        $genese = [];
        for ($i=0; $i < $size; $i++ )  {
            $genese[$i] = $characters[rand(0, count($characters) - 1)];
        }
  
        return $genese;
    }
}