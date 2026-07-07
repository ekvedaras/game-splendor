<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\Actions\OpenMine;
use Ekvedaras\SpaceSim\Planet;
use Ekvedaras\SpaceSim\World;

final readonly class PlanetaryIndustry implements Doctrine
{
    public function tick(World $world): void
    {

    }

    public function availableActions(World $world): array
    {
        return [
            ...array_map(fn (Planet $planet) => new OpenMine($planet), $world->planets),
            ...array_reduce($world->planets, fn (array $actions, Planet $planet) => [...$actions, ...$planet->structureActions], []),
        ];
    }
}