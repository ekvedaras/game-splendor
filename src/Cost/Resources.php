<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use Ekvedaras\SpaceSim\Resource;
use Webmozart\Assert\Assert;

final readonly class Resources implements Cost
{
    public function __construct(
        public Resource $of,
        /** @var int<1, 7> */
        public int $amount,
    ) {
        Assert::range($amount, 1, 7);
    }
}
