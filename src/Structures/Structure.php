<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Structures;

use Ekvedaras\SpaceSim\Actions\StructureAction;
use Ekvedaras\SpaceSim\Planet;

interface Structure
{
    public int $cost { get; }
    public int $energyProduction { get; }
    public int $energyConsumption { get; }

    /** @return list<StructureAction> */
    public function actions(Planet $planet): array;
}