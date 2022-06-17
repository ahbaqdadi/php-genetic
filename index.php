<?php

require_once __DIR__.'/vendor/autoload.php';

use Ahbaqdadi\PhpGenetic\Genetic;
use Ahbaqdadi\PhpGenetic\Infrastructure\DNAGenerator;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessString;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessBinaryDecimal;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessSortNumber;
use Ahbaqdadi\PhpGenetic\Infrastructure\Mutator;
use Ahbaqdadi\PhpGenetic\Model\GeneModel;


$genetic = new Genetic(
     $dnaGenerator = new DNAGenerator(),
     $fitness = new FitnessString(),
     $mutator = new Mutator(new DNAGenerator())
    );

$subject = "hello world";
$genetic = $genetic->run(str_split(GeneModel::STRING_GENES), str_split($subject), strlen($subject));
dump($genetic->toString());
dump($genetic->getTime());
dump($genetic->getEpoche());
dump($genetic->getReport());

die();