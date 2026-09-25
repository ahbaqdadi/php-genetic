<?php

namespace Ahbaqdadi\PhpGenetic;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;
use Ahbaqdadi\PhpGenetic\Bridge\MutatorInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Stopwatch\Stopwatch;

class Genetic
{
    private array $result = [];
    private string $time = '';
    private Stopwatch $stopwatch;
    private array $display = [];
    private int $epoche = 0;

    public function __construct(
        private DNAGeneratorInterface $dnaGenerator,
        private FitnessInterface $fitness,
        private MutatorInterface $mutator
    ) {
        $this->stopwatch = new Stopwatch();
    }

    public function run(
        array $genes,
        array $subject,
        int $sizeSubject,
        int $maxEpochs = 1_000_000
    ): self
    {
        if ($genes === []) {
            throw new InvalidArgumentException('At least one gene is required.');
        }

        if ($sizeSubject < 1) {
            throw new InvalidArgumentException('The subject size must be at least one.');
        }

        if ($maxEpochs < 1) {
            throw new InvalidArgumentException('The maximum number of epochs must be at least one.');
        }

        $this->stopwatch = new Stopwatch();
        $this->display = [];
        $this->epoche = 0;
        $this->result = [];
        $this->stopwatch->start('genetic');

        try {
            $dna = $this->dnaGenerator->generate($sizeSubject, $genes);

            if (count($dna) !== $sizeSubject) {
                throw new RuntimeException('The DNA generator returned an unexpected number of genes.');
            }

            $fitness = $this->fitness->getFitness($subject, $dna);

            while ($fitness < count($dna)) {
                if ($this->epoche >= $maxEpochs) {
                    throw new RuntimeException(sprintf(
                        'No solution was found within %d epochs.',
                        $maxEpochs
                    ));
                }

                ++$this->epoche;
                $mutate = $this->mutator->mutate($dna, $genes);
                $newFitness = $this->fitness->getFitness($subject, $mutate);

                if ($newFitness < $fitness) {
                    continue;
                }

                $dna = $mutate;
                $this->display($dna, $fitness, $subject);
                $fitness = $newFitness;
            }

            $this->result = $dna;

            return $this;
        } finally {
            $this->time = (string) $this->stopwatch->stop('genetic');
        }
    }

    public function toString(): string
    {
        return implode('', $this->result);
    }

    public function toArray(): array
    {
        return $this->result;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getReport(): array
    {
        return $this->display;
    }

    public function getEpoche(): int
    {
        return $this->epoche;
    }

    private function display(array $dna, float $oldFitness, array $subject): void
    {
        $fitness = $this->fitness->getFitness($subject, $dna);
        if ($oldFitness !== $fitness) {
            $display['generation'] = $fitness;
            $display['dna'] = $dna;
            $display['string'] = implode('', $dna);
            $display['time'] = (string)$this->stopwatch->lap('genetic');
            $display['epoche'] = $this->epoche;
            $this->display[] = $display;
        }
    }
}
