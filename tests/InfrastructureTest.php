<?php

declare(strict_types=1);

namespace Ahbaqdadi\PhpGenetic\Tests;

use Ahbaqdadi\PhpGenetic\Infrastructure\DNAGenerator;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessSortNumber;
use Ahbaqdadi\PhpGenetic\Infrastructure\Mutator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class InfrastructureTest extends TestCase
{
    public function testGeneratorRejectsAnEmptyGenePool(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one gene is required.');

        (new DNAGenerator())->generate(1, []);
    }

    public function testMutatorRejectsAGenePoolWithoutAnAlternative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The gene pool must contain an alternative value.');

        (new Mutator(new DNAGenerator()))->mutate(['a'], ['a']);
    }

    public function testSortNumberFitnessHandlesBoundarySizes(): void
    {
        $fitness = new FitnessSortNumber();

        self::assertSame(0.0, $fitness->getFitness([], []));
        self::assertSame(1.0, $fitness->getFitness([], [42]));
    }

    public function testSortNumberFitnessCountsStrictlyIncreasingRuns(): void
    {
        $fitness = new FitnessSortNumber();

        self::assertSame(4.0, $fitness->getFitness([], [1, 2, 3, 4]));
        self::assertSame(2.0, $fitness->getFitness([], [1, 3, 2, 2]));
        self::assertSame(1.0, $fitness->getFitness([], [4, 3, 2, 1]));
    }
}
