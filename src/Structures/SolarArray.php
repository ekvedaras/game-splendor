<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Structures;

use Ekvedaras\SpaceSim\Planet;

final class SolarArray implements Structure
{
    public int $energyProduction = 10;
    public int $energyConsumption = 0;

    public function actions(Planet $planet): array
    {
        return [
        ];
    }
}