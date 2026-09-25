<?php

declare(strict_types=1);

namespace Ahbaqdadi\PhpGenetic\Tests;

use Ahbaqdadi\PhpGenetic\Infrastructure\DNAGenerator;
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
}
