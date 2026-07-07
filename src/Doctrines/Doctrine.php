<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\World;

interface Doctrine
{
    public function tick(World $world): void;
}