<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Webmozart\Assert\Assert;

final class SystemNode implements \Stringable
{
    public float $output {
        get => $this->baseOutput * $this->efficiency;
    }

    public SystemState $state = SystemState::Healthy;

    public function __construct(
        /** @var non-empty-string */
        public readonly string $name,
        /** @var positive-int */
        private(set) int $energyDemand,
        /** @var positive-int */
        private(set) int $priority,
        private(set) float $complexity,
        /** @var positive-int */
        private(set) int $baseOutput = 10,
        public float $efficiency = 1.0,
    )
    {
        Assert::notEmpty($this->name, 'System node name cannot be empty.');
        Assert::positiveInteger($this->energyDemand, 'System node energy demand must be positive. Got: %d');
        Assert::positiveInteger($this->priority, 'System node priority must be positive. Got: %d');
        Assert::positiveInteger($this->baseOutput, 'System node base output must be positive. Got: %d');
        Assert::greaterThan($this->complexity, 0,'System node complexity must be positive. Got: %d');
        Assert::lessThan($this->complexity, 1,'System node complexity must less than %2$d. Got: %d');
    }

    public function __toString(): string
    {
        return sprintf("  #%d %s: %s ⚡%d 📈%0.3f 🔧%0.3f -> %d", $this->priority, $this->name, $this->state->toString(), $this->energyDemand, $this->efficiency, $this->complexity, $this->output);
    }

    public function degradeState(): void
    {
        $this->state = match ($this->state) {
            SystemState::Healthy => SystemState::Degraded,
            SystemState::Degraded, SystemState::Critical => SystemState::Critical,
        };
    }
}