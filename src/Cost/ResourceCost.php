<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use Ekvedaras\SpaceSim\Resource;

interface ResourceCost extends Cost
{
    public Resource $of { get; }
}