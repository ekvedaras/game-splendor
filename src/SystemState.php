<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

enum SystemState
{
    case Healthy;
    case Degraded;
    case Critical;

    public function toString(): string
    {
        return match ($this) {
            self::Healthy => "🟢",
            self::Degraded => "🟠",
            self::Critical => "🔴",
        };
    }
}
