<?php

declare(strict_types=1);

namespace VerbaGuard;

enum Severity: string
{
    case Clean = 'clean';
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function scoreValue(): int
    {
        return match ($this) {
            self::Clean => 0,
            self::Low => 10,
            self::Medium => 25,
            self::High => 50,
        };
    }

    public static function fromString(string $severity): self
    {
        return self::from($severity);
    }

    public static function max(self $a, self $b): self
    {
        $order = [
            self::Clean->value => 0,
            self::Low->value => 1,
            self::Medium->value => 2,
            self::High->value => 3,
        ];

        return $order[$a->value] >= $order[$b->value] ? $a : $b;
    }
}
