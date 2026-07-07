<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\World;

final class IndustryDoctrine implements Doctrine
{
    public function tick(World $world): void
    {
        $world->energyConsumption += 2;
        $world->complexity += 2;
    }
}