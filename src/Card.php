<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Cost\Cost;

/** @template T of value-of<Level> */
final readonly class Card
{
    public function __construct(
        /** @var T */
        public Level $level,
        public Resource $resource,
        public Cost $cost,
        /** @var int<0, 7> */
        public int $points,
    ) {
    }

    public function toCliString(): string
    {
        return "{$this->resource->toCliColor()}{$this->points}\e[0m \e[0;30m·\e[0m {$this->cost->toCliString()}";
    }
}
