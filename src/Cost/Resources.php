<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Cost;

use Ekvedaras\SpaceSim\Resource;
use Webmozart\Assert\Assert;

final readonly class Resources implements ResourceCost
{
    public function __construct(
        public Resource $of,
        /** @var positive-int */
        public int $amount,
    ) {
        Assert::positiveInteger($amount);
    }
}