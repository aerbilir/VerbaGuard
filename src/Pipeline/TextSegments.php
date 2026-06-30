<?php

declare(strict_types=1);

namespace VerbaGuard\Pipeline;

final class TextSegments
{
    /**
     * @param list<SegmentRun> $runs
     */
    public function __construct(
        private readonly array $runs,
    ) {
    }

    public static function from(string $original): self
    {
        if ($original === '') {
            return new self([]);
        }

        $runs = [];
        $length = mb_strlen($original, 'UTF-8');
        $index = 0;

        while ($index < $length) {
            $byteStart = strlen(mb_substr($original, 0, $index, 'UTF-8'));
            $char = mb_substr($original, $index, 1, 'UTF-8');
            $isLetter = self::isAlphaNumeric($char);
            $text = $char;
            $nextIndex = $index + 1;

            while ($nextIndex < $length) {
                $nextChar = mb_substr($original, $nextIndex, 1, 'UTF-8');

                if (self::isAlphaNumeric($nextChar) !== $isLetter) {
                    break;
                }

                $text .= $nextChar;
                $nextIndex++;
            }

            $byteLength = strlen(mb_substr($original, $byteStart, mb_strlen($text, 'UTF-8'), 'UTF-8'));

            $runs[] = new SegmentRun(
                $isLetter ? 'letter' : 'separator',
                $byteStart,
                $byteLength,
                $text,
            );

            $index = $nextIndex;
        }

        return new self($runs);
    }

    /**
     * @return list<SegmentRun>
     */
    public function runs(): array
    {
        return $this->runs;
    }

    /**
     * @return list<int>
     */
    public function letterRunIndices(): array
    {
        $indices = [];

        foreach ($this->runs as $index => $run) {
            if ($run->isLetter()) {
                $indices[] = $index;
            }
        }

        return $indices;
    }

    private static function isAlphaNumeric(string $char): bool
    {
        return (bool) preg_match('/[\p{L}\p{N}]/u', $char);
    }
}

final class SegmentRun
{
    public function __construct(
        private readonly string $type,
        private readonly int $byteStart,
        private readonly int $byteLength,
        private readonly string $text,
    ) {
    }

    public function isLetter(): bool
    {
        return $this->type === 'letter';
    }

    public function isSeparator(): bool
    {
        return $this->type === 'separator';
    }

    public function byteStart(): int
    {
        return $this->byteStart;
    }

    public function byteLength(): int
    {
        return $this->byteLength;
    }

    public function byteEnd(): int
    {
        return $this->byteStart + $this->byteLength;
    }

    public function text(): string
    {
        return $this->text;
    }
}
