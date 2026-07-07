<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Structures;

use Ekvedaras\SpaceSim\Planet;

final class OrbitalStation implements Structure
{
    public int $energyProduction = 0;
    public int $energyConsumption = 0;

    public function actions(Planet $planet): array
    {
        return [
        ];
    }
}