<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Planet;

interface PlanetAction extends Action
{
    public Planet $planet { get; }
}