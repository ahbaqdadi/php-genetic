<?php

declare(strict_types=1);

namespace Ahbaqdadi\PhpGenetic\Tests;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;
use Ahbaqdadi\PhpGenetic\Bridge\MutatorInterface;
use Ahbaqdadi\PhpGenetic\Genetic;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class GeneticTest extends TestCase
{
    public function testItReturnsTheEvolvedDnaAsAnArrayAndString(): void
    {
        $genetic = new Genetic(
            new FixedGenerator(['a', 'a']),
            new MatchingFitness(),
            new FixedMutator(['b', 'a']),
        );

        $genetic->run(['a', 'b'], ['b', 'a'], 2);

        self::assertSame(['b', 'a'], $genetic->toArray());
        self::assertSame('ba', $genetic->toString());
        self::assertSame(1, $genetic->getEpoche());
    }

    public function testItDoesNotMutateAnAlreadyPerfectCandidate(): void
    {
        $genetic = new Genetic(
            new FixedGenerator(['a']),
            new MatchingFitness(),
            new FailingMutator(),
        );

        $genetic->run(['a', 'b'], ['a'], 1);

        self::assertSame(['a'], $genetic->toArray());
        self::assertSame(0, $genetic->getEpoche());
    }

    public function testItRejectsAnEmptyGenePool(): void
    {
        $genetic = new Genetic(
            new FixedGenerator(['a']),
            new MatchingFitness(),
            new FailingMutator(),
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('At least one gene is required.');

        $genetic->run([], ['a'], 1);
    }

    public function testItStopsAtTheEpochBudget(): void
    {
        $genetic = new Genetic(
            new FixedGenerator(['a']),
            new MatchingFitness(),
            new FixedMutator(['a']),
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No solution was found within 2 epochs.');

        $genetic->run(['a', 'b'], ['b'], 1, 2);
    }
}

final class FixedGenerator implements DNAGeneratorInterface
{
    public function __construct(private readonly array $dna)
    {
    }

    public function generate(int $size, array $characters): array
    {
        return $this->dna;
    }
}

final class MatchingFitness implements FitnessInterface
{
    public function getFitness(array $target, array $genes): float
    {
        return (float) count(array_intersect_assoc($target, $genes));
    }
}

final class FixedMutator implements MutatorInterface
{
    public function __construct(private readonly array $dna)
    {
    }

    public function mutate(array $dna, array $genes): array
    {
        return $this->dna;
    }
}

final class FailingMutator implements MutatorInterface
{
    public function mutate(array $dna, array $genes): array
    {
        self::fail('The mutator must not run for an already-perfect candidate.');
    }
}
