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

    public function __construct(
        private GeneModelInterface $geneModel,
        private DNAGeneratorInterface $dnaGenerator,
        private FitnessInterface $fitness,
        private MutatorInterface $mutator
        )
    {
        $this->stopwatch = new Stopwatch();
    }

    public function run()
    {
        $this->stopwatch->start('genetic');
        $dna = $this->dnaGenerator->generate(count($this->geneModel->getSubject()), $this->geneModel->getGenes());
        $fitness = $this->fitness->getFitness($this->geneModel->getSubject(), $dna);

        while(true)
        {
            $mutate =  $this->mutator->mutate($dna, $this->geneModel->getGenes());
            $newFitness = $this->fitness->getFitness($this->geneModel->getSubject(), $mutate);

            if ($newFitness < $fitness) {
                continue;
            }

            $dna = $mutate;
            $this->display($dna, $fitness);
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

    private function display($dna, $oldFitness)
    {
        $fitness = $this->fitness->getFitness($this->geneModel->getSubject(), $dna);
        if ($oldFitness !== $fitness) {
            $display['generation'] = $fitness;
            $display['dna'] = $dna;
            $display['string'] = implode('', $dna);
            $display['time'] = (string)$this->stopwatch->lap('genetic');
            $this->display[] = $display;
        }
    }
}