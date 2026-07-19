<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

final readonly class PlayerInput
{
    public function __construct(
        public string $input,
    ) {
    }
}
