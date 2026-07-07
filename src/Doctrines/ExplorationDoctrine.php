<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\World;

final class ExplorationDoctrine implements Doctrine
{
    public function tick(World $world): void
    {
        $world->energyConsumption += 1;
        $world->detectability += 1;
    }

    // todo allow scan planets action (auto)
}