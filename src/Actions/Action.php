<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Planet;
use Ekvedaras\SpaceSim\World;

interface Action extends \Stringable
{
    public function execute(World $world): void;
}