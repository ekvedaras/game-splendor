<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\World;

final class SocietyDoctrine implements Doctrine
{
    public function tick(World $world): void
    {
        $world->population += 10;
        $world->energyConsumption += 1;
    }
}