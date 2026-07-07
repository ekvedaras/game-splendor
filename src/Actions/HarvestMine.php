<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Structures\Mine;
use Ekvedaras\SpaceSim\World;
use Ekvedaras\SpaceSim\Planet;

final class HarvestMine implements StructureAction
{
    public function __construct(
        public Planet $planet,
        public Mine $structure,
    ) {
    }

    public function execute(World $world): void
    {
        $world->generateEnergy($this->structure->energyProduction);
    }

    public function __toString(): string
    {
        return "Harvest mine on planet {$this->planet->name}";
    }
}