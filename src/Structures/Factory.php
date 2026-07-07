<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Structures;

use Ekvedaras\SpaceSim\Planet;

final class Factory implements Structure
{
    public int $energyProduction = 1;
    public int $energyConsumption = 6;

    public function actions(Planet $planet): array
    {
        return [
        ];
    }
}