<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Actions\StructureAction;
use Ekvedaras\SpaceSim\Structures\Structure;

final class Planet
{
    /** @var list<Structure> */
    private(set) array $structures = [];

    public function __construct(
        /** @var non-empty-string */
        public readonly string $name,
        public readonly World $world,
        /** @var non-negative-int */
        private(set) int $population,
    ) {
    }

    public int $energyProduction {
        get => array_sum(array_map(fn (Structure $structure) => $structure->energyProduction, $this->structures));
    }

    public int $energyConsumption {
        get => $this->population + (int) array_sum(array_map(fn (Structure $structure) => $structure->energyConsumption, $this->structures));
    }

    /** @var list<StructureAction> */
    public array $structureActions {
        get => array_reduce($this->structures, fn (array $actions, Structure $structure) => [...$actions, ...$structure->actions($this)], []);
    }

    public function buildStructure(Structure $structure): void
    {
        $this->structures[] = $structure;
    }
}