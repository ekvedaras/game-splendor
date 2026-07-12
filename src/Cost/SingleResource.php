<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use Ekvedaras\SpaceSim\Resource;

final readonly class SingleResource implements ResourceCost
{
    public function __construct(
        public Resource $of,
    )
    {
    }
}