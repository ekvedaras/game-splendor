<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Webmozart\Assert\Assert;

final class World implements \Stringable
{
    /** @var non-empty-list<SystemNode> */
    private array $systems = [];

    private(set) float $cumulativeOutput = 0.0;
    private(set) float $lastOutput = 0.0;
    public float $complexity {
        get => array_sum(array_map(fn (SystemNode $system) => $system->complexity, $this->systems));
    }

    public function __construct(
        private(set) int $availableEnergy,
        public int $energyProduction,
        SystemNode ...$systems,
    )
    {
        Assert::notEmpty($systems, 'World needs at least one system in it');

        usort($systems, fn(SystemNode $a, SystemNode $b) => $a->priority <=> $b->priority);
        $this->systems = array_values($systems);
    }

    public function tick(): void
    {
        $availableEnergy = $this->availableEnergy + $this->energyProduction;
        $output = 0;

        foreach ($this->systems as $system) {
            if ($availableEnergy <= 0) {
                $system->efficiency = 0.2; // degraded node
                $output += $system->output;
                continue;
            }

            if ($availableEnergy >= $system->energyDemand) {
                $availableEnergy -= $system->energyDemand;
//                $system->efficiency = 1.0;
                $output += $system->output;

                continue;
            }

            // partial supply = slowdown
            $ratio = $availableEnergy / $system->energyDemand;
            $system->efficiency = max(0.2, $ratio);
            $output += $system->output;
            $availableEnergy = 0;
        }

        $this->availableEnergy = $availableEnergy;
        $this->lastOutput = $output * (count($this->systems) - $this->complexity);
        $this->cumulativeOutput += $this->lastOutput;
    }

    public function reduceEfficiency(float $by): void
    {
        foreach ($this->systems as $system) {
            $system->efficiency = max(0.2, $system->efficiency - $by);
        }
    }

    public function randomSystem(): SystemNode
    {
        return $this->systems[array_rand($this->systems)];
    }

    public function __toString(): string
    {
        return implode("\n", $this->systems)
               . "\nAvailable energy: ⚡{$this->availableEnergy}"
               . sprintf("\nOutput -> %0.3f (%0.3f) / 🔧%0.3f \n ", $this->cumulativeOutput, $this->lastOutput, $this->complexity)
            ;
    }
}