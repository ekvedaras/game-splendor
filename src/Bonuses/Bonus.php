<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Bonuses;

use Ekvedaras\SpaceSim\Cost\Cost;

interface Bonus
{
    public Cost $cost { get; }
    public int $points { get; }
}
