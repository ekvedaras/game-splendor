<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Structures;

use Ekvedaras\SpaceSim\Actions\HarvestMine;
use Ekvedaras\SpaceSim\Planet;

final class Mine implements Structure
{
    public int $cost = 20;
    public int $energyProduction = 10;
    public int $energyConsumption = 5;

    public function actions(Planet $planet): array
    {
        return [
            new HarvestMine($planet, $this),
        ];
    }

}