<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\World;

final class QuitGame implements Action
{
    public function execute(World $world): never
    {
        die('Bye');
    }

    public function __toString(): string
    {
        return 'Quit';
    }
}