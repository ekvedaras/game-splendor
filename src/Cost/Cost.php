<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

interface Cost
{
    public function toCliString(): string;
}
