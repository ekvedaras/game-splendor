<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

final readonly class NoCardInSlot
{
    public function __construct(
        /** @var int<0, 3> */
        public int $position,
    ) {
    }
}