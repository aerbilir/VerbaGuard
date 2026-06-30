<?php

declare(strict_types=1);

namespace VerbaGuard;

use VerbaGuard\Contracts\LanguageProfile;
use VerbaGuard\Language\TurkishProfile;
use VerbaGuard\Pipeline\Pipeline;

final class VerbaGuard
{
    /** @var list<LanguageProfile> */
    private array $profiles;

    /**
     * @param list<LanguageProfile> $profiles
     */
    private function __construct(array $profiles)
    {
        $this->profiles = $profiles;
    }

    public static function turkish(): self
    {
        return self::forLanguages([new TurkishProfile()]);
    }

    /**
     * @param list<LanguageProfile> $profiles
     */
    public static function forLanguages(array $profiles): self
    {
        return new self($profiles);
    }

    public function contains(string $text): bool
    {
        return $this->analyze($text)->hasProfanity();
    }

    public function analyze(string $text): AnalysisResult
    {
        return (new Pipeline($this->profiles))->analyze($text);
    }

    public function mask(string $text, string $mask = '*'): string
    {
        return $this->analyze($text)->masked($mask);
    }

    public function score(string $text): int
    {
        return $this->analyze($text)->score();
    }
}
