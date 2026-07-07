<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Doctrines\Doctrine;
use Ekvedaras\SpaceSim\World;

final readonly class ChangeDoctrine implements Action
{
    public function __construct(
        public Doctrine $doctrine,
    ) {
    }

    public function execute(World $world): void
    {
        $world->doctrine = $this->doctrine;
        $world->allowChangingDoctrine = false;
    }

    public function __toString(): string
    {
        return 'Change doctrine to ' . str_replace(__NAMESPACE__, '', $this->doctrine::class);
    }
}