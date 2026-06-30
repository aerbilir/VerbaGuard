<?php

declare(strict_types=1);

namespace VerbaGuard;

final class ProfanityMatch
{
    public function __construct(
        private readonly string $original,
        private readonly string $normalized,
        private readonly string $term,
        private readonly string $language,
        private readonly string $category,
        private readonly string $severity,
        private readonly int $start,
        private readonly int $length,
    ) {
    }

    public function original(): string
    {
        return $this->original;
    }

    public function normalized(): string
    {
        return $this->normalized;
    }

    public function term(): string
    {
        return $this->term;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function severity(): string
    {
        return $this->severity;
    }

    public function start(): int
    {
        return $this->start;
    }

    public function length(): int
    {
        return $this->length;
    }
}
