<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

use Ekvedaras\SpaceSim\Level;

/** @template T of Level */
interface Deck
{
    /** @var T */
    public Level $level { get; }

    public function toCliString(): string;
}
