<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\World;

final class EnergyDoctrine implements Doctrine
{
    public function tick(World $world): void
    {
        $world->energyProduction += 10;
        $world->detectability += 2;
    }
}