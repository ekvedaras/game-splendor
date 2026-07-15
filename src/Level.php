<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

enum Level
{
    case First;
    case Second;
    case Third;

    public function toCliString(): string
    {
        return match ($this) {
            self::First => '  *',
            self::Second => ' **',
            self::Third => '***',
        };
    }
}
