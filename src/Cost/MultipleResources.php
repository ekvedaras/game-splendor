<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use SplObjectStorage;

final readonly class MultipleResources implements Cost
{
    /** @var SplObjectStorage<Resource, Resources> */
    public SplObjectStorage $resources;

    public function __construct(Resources ...$cost)
    {
        $resources = new SplObjectStorage();
        foreach ($cost as $resourceCost) {
            $resources[$resourceCost] = $resourceCost->of;
        }

        $this->resources = $resources;
    }

    public function toCliString(): string
    {
        $strings = [];
        foreach ($this->resources as $resource) {
            $strings[] = $resource->toCliString();
        }

        return implode(' ', $strings);
    }
}
