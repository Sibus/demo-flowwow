<?php

declare(strict_types=1);

namespace app\api\oxr;

class RateCollection implements \IteratorAggregate
{
    public readonly \DateTimeImmutable $timestamp;

    public function __construct(private readonly array $rates, int $timestamp)
    {
        $this->timestamp = (new \DateTimeImmutable())->setTimestamp($timestamp);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->rates);
    }
}
