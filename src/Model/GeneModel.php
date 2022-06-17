<?php

namespace Ahbaqdadi\PhpGenetic\Model;

use Ahbaqdadi\PhpGenetic\Bridge\GeneModelInterface;

class GeneModel implements GeneModelInterface
{
    public const STRING_GENES = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789:!@#$%^&*()-+,. ';

    private function __construct(private array $genes = [], private array $subject = [])
    {
       
    }

    public function getGenes(): array
    {
        return $this->genes;
    }

    public function getSubject(): array
    {
        return $this->subject;
    }

    public static function createFromArray(array $genes = [], array $subject = []): GeneModel
    {
        return new GeneModel($genes, $subject);
    }

    public static function createFromString(string $genes, string $subject): GeneModel
    {
        return new GeneModel(
            str_split($genes),
            str_split($subject)
        );
    }

    public static function createFromBinary(array $genes, string $subject)
    {
        return new GeneModel(
            $genes,
            [$subject]
        );
    }
}