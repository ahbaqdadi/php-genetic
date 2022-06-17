<?php

namespace  Ahbaqdadi\PhpGenetic\Bridge;

interface MutatorInterface{
    public function mutate(array $dna, array $genes): array;
}