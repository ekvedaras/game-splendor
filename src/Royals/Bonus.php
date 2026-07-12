<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Royals;

use Ekvedaras\SpaceSim\Cost\Cost;

interface Bonus
{
    public Cost $cost { get; }
    public int $points { get; }
}
