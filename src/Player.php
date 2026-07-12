<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Royals\Bonus;
use Webmozart\Assert\Assert;

final class Player
{
    /** @var list<Card<Level>> */
    private(set) array $cards = [];

    /** @var list<Bonus> */
    private(set) array $royals = [];

    public int $points {
        get => array_sum([
            ...array_map(fn (Card $card) => $card->points, $this->cards),
            ...array_map(fn (Bonus $royal) => $royal->points, $this->royals),
                             ]);
    }

    public function __construct(
        /** @var non-empty-string */
        public readonly string $name,
    ) {
        Assert::notEmpty($name);
    }
}
