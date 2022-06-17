<?php

namespace Ahbaqdadi\PhpGenetic\Bridge;

interface DNAGeneratorInterface
{
    public function generate(int $size, array $characters): array;
}