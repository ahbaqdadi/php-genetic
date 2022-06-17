<?php 

namespace Ahbaqdadi\PhpGenetic;

use Ahbaqdadi\PhpGenetic\Bridge\DNAGeneratorInterface;
use Ahbaqdadi\PhpGenetic\Bridge\FitnessInterface;
use Ahbaqdadi\PhpGenetic\Bridge\GeneModelInterface;
use Ahbaqdadi\PhpGenetic\Bridge\MutatorInterface;
use Ahbaqdadi\PhpGenetic\Model\GeneModel;
use DateTime;
use Symfony\Component\Stopwatch\Stopwatch;

class Genetic
{
    private array $resutl;
    private string $time;
    private Stopwatch $stopwatch;
    private array $display;
    private int $epoche = 0;

    public function __construct(
        private DNAGeneratorInterface $dnaGenerator,
        private FitnessInterface $fitness,
        private MutatorInterface $mutator
        )
    {
        $this->stopwatch = new Stopwatch();
    }

    public function run($genes, $subject, $sizeSubject)
    {
        $this->stopwatch->start('genetic');
        $dna = $this->dnaGenerator->generate($sizeSubject, $genes);
        $fitness = $this->fitness->getFitness($subject, $dna);

        while(true)
        {
            $this->epoche += 1;
            $mutate =  $this->mutator->mutate($dna, $genes);
            $newFitness = $this->fitness->getFitness($subject, $mutate);

            if ($newFitness < $fitness) {
                continue;
            }

            $dna = $mutate;
            $this->display($dna, $fitness, $subject);
            $fitness = $newFitness;
            
            if ($newFitness >= count($dna)) {
                break;
            }
        }
        $this->time = (string)$this->stopwatch->stop('genetic');
        $this->resutl = $dna;

        return $this;
    }

    public function toString()
    {
        return implode('', $this->resutl);
    }

    public function toArray()
    {
        return $this->result;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getReport()
    {
        return $this->display;
    }

    public function getEpoche()
    {
        return $this->epoche;
    }

    private function display($dna, $oldFitness, $subject)
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