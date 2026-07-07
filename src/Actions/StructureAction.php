<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\World;
use Ekvedaras\SpaceSim\Planet;
use Ekvedaras\SpaceSim\Structures\Structure;

interface StructureAction extends PlanetAction
{
    public Structure $structure { get; }
}