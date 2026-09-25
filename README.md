# php-genetic

A small genetic-algorithm toolkit for PHP 8.1+. Supply a DNA generator, fitness
function, and mutator, then evolve a candidate until the fitness reaches the DNA
length.

> This is an experimental learning project, not a general-purpose optimization
> framework. See [Limitations](#limitations) before using it for unbounded work.

## Installation

The package is not currently published on Packagist. Install the development
branch directly from GitHub:

```bash
composer config repositories.php-genetic vcs https://github.com/ahbaqdadi/php-genetic
composer require ahbaqdadi/php-genetic:dev-main
```

## Quick start

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Ahbaqdadi\PhpGenetic\Genetic;
use Ahbaqdadi\PhpGenetic\Infrastructure\DNAGenerator;
use Ahbaqdadi\PhpGenetic\Infrastructure\FitnessString;
use Ahbaqdadi\PhpGenetic\Infrastructure\Mutator;
use Ahbaqdadi\PhpGenetic\Model\GeneModel;

$generator = new DNAGenerator();
$genetic = new Genetic(
    $generator,
    new FitnessString(),
    new Mutator($generator),
);

$target = str_split('hello world');
$genetic->run(
    str_split(GeneModel::STRING_GENES),
    $target,
    count($target),
);

echo $genetic->toString(); // hello world
```

Use `toArray()` for the evolved genes, `getEpoche()` for the attempted mutation
count, `getTime()` for elapsed time, and `getReport()` for fitness improvements.

`run()` accepts an optional fourth argument that caps mutation attempts. It
defaults to 1,000,000 and throws `RuntimeException` if no solution is found in
that budget:

```php
$genetic->run($genes, $target, count($target), maxEpochs: 10_000);
```

## Input requirements

- The gene pool must not be empty.
- The requested subject size and epoch budget must be positive.
- The built-in mutator needs at least one value different from the selected DNA
  gene. It rejects an unusable pool instead of recursing indefinitely.
- A fitness implementation must use the DNA length as its success score. With
  `FitnessString`, every target value must therefore be reachable from the gene
  pool.

Custom strategies can implement the interfaces in `src/Bridge`.

## Development

```bash
composer install
composer test
```

## Limitations

- The algorithm keeps only the current candidate; it does not maintain a
  population or perform crossover.
- Runs are synchronous and keep improvement reports in memory.
- A reachable solution is not guaranteed, so callers should choose an epoch
  budget appropriate for their workload.
