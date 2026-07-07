<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Doctrines;

use Ekvedaras\SpaceSim\Actions\Action;
use Ekvedaras\SpaceSim\World;

interface Doctrine
{
    public function tick(World $world): void;

    /** @return list<Action> */
    public function availableActions(World $world): array;
}