# Changelog

All notable changes to this project are documented in this file.

The project follows [Semantic Versioning](https://semver.org/). While the major
version is zero, minor releases may include breaking API changes.

## [0.1.0] - 2026-09-29

Initial experimental release.

### Added

- Pluggable DNA generator, fitness, and mutator interfaces.
- Built-in string, numeric-sorting, and binary-decimal fitness strategies.
- Configurable epoch budgets with clear failures for unreachable solutions.
- Result, timing, epoch, and fitness-improvement reporting.
- Input validation for invalid or non-terminating generator and mutator cases.
- Deterministic regression tests and CI on PHP 8.1, 8.3, and 8.5.

### Requirements and limitations

- Requires PHP 8.1 or newer.
- Uses a single current candidate; population selection and crossover are not
  implemented.
- Runs synchronously and keeps improvement reports in memory.

[0.1.0]: https://github.com/ahbaqdadi/php-genetic/releases/tag/v0.1.0
