<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Bonuses;

use Ekvedaras\SpaceSim\Cost\Cost;
use Ekvedaras\SpaceSim\Cost\MultipleResources;
use Ekvedaras\SpaceSim\Cost\Resources;
use Ekvedaras\SpaceSim\Resources\Resource;

final readonly class WhiteAndGreen implements Bonus
{
    public Cost $cost;
    public int $points;

    public function __construct()
    {
        $this->cost = new MultipleResources(
            new Resources(of: Resource::White, amount: 4),
            new Resources(of: Resource::Green, amount: 4),
        );
        $this->points = 5;
    }
}
