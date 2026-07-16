<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Resources;

use Ekvedaras\SpaceSim\Cost\Cost;
use Ekvedaras\SpaceSim\Cost\MultipleResources;
use Ekvedaras\SpaceSim\Cost\Resources;
use Webmozart\Assert\Assert;

enum Resource
{
    case Black;        // black
    case White;        // white
    case Red;          // red
    case Blue;         // blue
    case Green;        // green
    case Yellow;       // yellow

    public function toCliString(): string
    {
        return $this->toCliColor() . "⏺\e[0m";
    }

    public function toCliColor(): string
    {
        return match ($this) {
            self::Black => "\e[0;30m",
            self::White => "\e[0;37m",
            self::Red => "\e[0;31m",
            self::Green => "\e[0;32m",
            self::Blue => "\e[0;34m",
            self::Yellow => "\e[0;33m",
        };
    }

    public function one(): Resources
    {
        return $this->times(1);
    }

    /** @param int<1, 7> $amount */
    public function times(int $amount): Resources
    {
        return new Resources(of: $this, amount: $amount);
    }

    public static function oneOfAll(): MultipleResources
    {
        return new MultipleResources(
            self::Black->one(),
            self::White->one(),
            self::Red->one(),
            self::Blue->one(),
            self::Green->one(),
        );
    }

    /**
     * @param int<0, 7> $black
     * @param int<0, 7> $white
     * @param int<0, 7> $red
     * @param int<0, 7> $blue
     * @param int<0, 7> $green
     * @return Cost
     */
    public static function cost(int $black, int $white, int $red, int $blue, int $green): Cost
    {
        /** @var array<int, Resources> $cost */
        $cost = array_filter([
                                 $black > 0 ? self::Black->times($black) : false,
                                 $white > 0 ? self::White->times($white) : false,
                                 $red > 0 ? self::Red->times($red) : false,
                                 $blue > 0 ? self::Blue->times($blue) : false,
                                 $green > 0 ? self::Green->times($green) : false,
                             ]);

        Assert::notEmpty($cost, 'Total cost cannot be 0');

        if (count($cost) === 1) {
            return array_first($cost);
        }

        return new MultipleResources(...$cost);
    }
}
