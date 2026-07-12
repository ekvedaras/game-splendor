<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

use Ekvedaras\SpaceSim\Level;

/** @template T of value-of<Level> */
interface Deck
{
    /** @var T */
    public Level $level { get; }
}