<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Planet;
use Ekvedaras\SpaceSim\Structures\Mine;
use Ekvedaras\SpaceSim\World;

final class OpenMine implements PlanetAction
{
    public function __construct(
        public Planet $planet,
    ) {
    }

    public function execute(World $world): void
    {
        $structure = new Mine();
        $this->planet->buildStructure($structure);
        $this->planet->world->consumeEnergy($structure->cost);
    }

    public function __toString(): string
    {
        return "Open mine on planet {$this->planet->name}";
    }
}