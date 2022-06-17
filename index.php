<?php

require_once __DIR__.'/vendor/autoload.php';

use Ahbaqdadi\PhpGenetic\Genetic;
use Ahbaqdadi\PhpGenetic\Infrastructure\DNAGenerator;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessString;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessBinaryDecimal;
use Ahbaqdadi\PhpGenetic\Infrastructure\Mutator;
use Ahbaqdadi\PhpGenetic\Model\GeneModel;


$genetic = new Genetic(
     $geneModel = GeneModel::createFromString(GeneModel::STRING_GENES, ':D test haha :D'),
     $dnaGenerator = new DNAGenerator(),
     $fitness = new FitnessString(),
     $mutator = new Mutator(new DNAGenerator())
    );


$genetic = $genetic->run();
dump($genetic->toString());
dump($genetic->getTime());
dump($genetic->getReport());
die();