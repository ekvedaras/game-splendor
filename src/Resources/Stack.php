<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Resources;

use Webmozart\Assert\Assert;

/** @template T of Resource */
final class Stack
{
    public function __construct(
        /** @var T */
        public readonly Resource $of,
        /** @var non-negative-int */
        private(set) int $amount = 0,
    ) {
        Assert::notNegativeInteger($amount);
    }

    public function takeOne(): self
    {
        Assert::greaterThan($this->amount, 0, 'No more resources in the stack to take.');
        $this->amount--;

        return new self($this->of, 1);
    }

    public function takeTwo(): self
    {
        Assert::greaterThan($this->amount, 3, 'Cannot take 2 resources when there is less than 4 in the stack.');

        $this->amount -= 2;

        return new self($this->of, 2);
    }

    /** @param self<T> $stack */
    public function add(self $stack): self
    {
        Assert::same($this->of, $stack->of);

        $this->amount += $stack->amount;

        return $this;
    }

    public function toCliString(): string
    {
        return str_repeat($this->of->toCliString(), $this->amount);
    }
}
