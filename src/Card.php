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
        /** @var int<0, 5> */
        public int $points,
    ) {
    }
}