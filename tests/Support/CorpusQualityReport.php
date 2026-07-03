<?php

declare(strict_types=1);

namespace VerbaGuard\Tests\Support;

use VerbaGuard\VerbaGuard;

final class CorpusQualityReport
{
    /** @var list<string> */
    private array $falsePositiveCases = [];

    /** @var list<string> */
    private array $falseNegativeCases = [];

    private int $positiveExpectationCount = 0;

    private int $positiveDetectionCount = 0;

    /**
     * @param list<array<string, mixed>> $cases
     */
    public function __construct(
        private readonly VerbaGuard $guard,
        array $cases,
    ) {
        foreach ($cases as $case) {
            $this->evaluateCase($case);
        }
    }

    /**
     * @param list<array<string, mixed>> $cases
     */
    public static function fromCases(VerbaGuard $guard, array $cases): self
    {
        return new self($guard, $cases);
    }

    public static function fromAllFixtures(VerbaGuard $guard): self
    {
        return new self($guard, CorpusLoader::all());
    }

    public static function fromDetectionCorpus(VerbaGuard $guard): self
    {
        return new self($guard, [
            ...CorpusLoader::loadProfane(),
            ...CorpusLoader::loadObfuscated(),
        ]);
    }

    public function falsePositiveCount(): int
    {
        return count($this->falsePositiveCases);
    }

    public function falseNegativeCount(): int
    {
        return count($this->falseNegativeCases);
    }

    public function detectionCoverage(): float
    {
        if ($this->positiveExpectationCount === 0) {
            return 100.0;
        }

        return ($this->positiveDetectionCount / $this->positiveExpectationCount) * 100;
    }

    /**
     * @return list<string>
     */
    public function falsePositiveCases(): array
    {
        return $this->falsePositiveCases;
    }

    /**
     * @return list<string>
     */
    public function falseNegativeCases(): array
    {
        return $this->falseNegativeCases;
    }

    /**
     * @param array<string, mixed> $case
     */
    private function evaluateCase(array $case): void
    {
        /** @var array{detected: bool} $expect */
        $expect = $case['expect'];
        $id = $case['id'];
        $text = $case['text'];
        $detected = $this->guard->contains($text);

        if ($expect['detected']) {
            $this->positiveExpectationCount++;

            if ($detected) {
                $this->positiveDetectionCount++;
            } else {
                $this->falseNegativeCases[] = $id;
            }
        } elseif ($detected) {
            $this->falsePositiveCases[] = $id;
        }
    }
}
