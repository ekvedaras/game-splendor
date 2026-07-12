<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use SplObjectStorage;

final readonly class MultipleResources implements Cost
{
    /** @var SplObjectStorage<Resource, ResourceCost> */
    public SplObjectStorage $resources;

    public function __construct(ResourceCost ...$cost)
    {
        $resources = new SplObjectStorage();
        foreach ($cost as $resourceCost) {
            $resources[$resourceCost] = $resourceCost->of;
        }

        $this->resources = $resources;
    }
}