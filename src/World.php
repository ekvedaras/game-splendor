<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Doctrines\Doctrine;

use function Laravel\Prompts\table;

final class World
{
    public ?self $previous;

    public function __construct(
        public Doctrine $doctrine,
        public int $energy,
        public int $population,
        public int $energyProduction,
        public int $energyConsumption,
        public int $detectability,
        public int $complexity,
    ) {
    }

    public function tick(): void
    {
        $this->previous = clone $this;

        $this->doctrine->tick($this);

        $this->population += 1;
        $this->energy += $this->energyProduction - $this->energyConsumption;
    }

    private function diff(): array
    {
        if (!isset($this->previous)) {
            return [
                'energy'            => '',
                'population'        => '',
                'energyProduction'  => '',
                'energyConsumption' => '',
                'detectability'     => '',
                'complexity'        => '',
            ];
        }

        return [
            'energy'            => ' ' . match (true) {
                    $this->energy < $this->previous->energy => '-',
                    $this->energy > $this->previous->energy => '+',
                    default => '',
                } . round(abs($this->energy - $this->previous->energy) * 100 / $this->previous->energy) . '%',
            'population'        => ' ' . match (true) {
                    $this->population < $this->previous->population => '-',
                    $this->population > $this->previous->population => '+',
                    default => '',
                } . round(abs($this->population - $this->previous->population) * 100 / $this->previous->population) . '%',
            'energyProduction'  => ' ' . match (true) {
                    $this->energyProduction < $this->previous->energyProduction => '-',
                    $this->energyProduction > $this->previous->energyProduction => '+',
                    default => '',
                } . round(abs($this->energyProduction - $this->previous->energyProduction) * 100 / $this->previous->energyProduction) . '%',
            'energyConsumption' => ' ' . match (true) {
                    $this->energyConsumption < $this->previous->energyConsumption => '-',
                    $this->energyConsumption > $this->previous->energyConsumption => '+',
                    default => '',
                } . round(abs($this->energyConsumption - $this->previous->energyConsumption) * 100 / $this->previous->energyConsumption) . '%',
            'detectability'     => ' ' . match (true) {
                    $this->detectability < $this->previous->detectability => '-',
                    $this->detectability > $this->previous->detectability => '+',
                    default => '',
                } . round(abs($this->detectability - $this->previous->detectability) * 100 / $this->previous->detectability) . '%',
            'complexity'        => ' ' . match (true) {
                    $this->complexity < $this->previous->complexity => '-',
                    $this->complexity > $this->previous->complexity => '+',
                    default => '',
                } . round(abs($this->complexity - $this->previous->complexity) * 100 / $this->previous->complexity) . '%',
        ];
    }

    public function print(): void
    {
        $diff = $this->diff();

        table(['Doctrine', 'Energy', 'Population', 'Energy production', 'Energy concumption', 'detectability', 'complexity'],
              [
                  [
                      'doctrine'          => $this->doctrine::class,
                      'energy'            => $this->energy . $diff['energy'],
                      'population'        => $this->population . $diff['population'],
                      'energyProduction'  => $this->energyProduction . $diff['energyProduction'],
                      'energyConsumption' => $this->energyConsumption . $diff['energyConsumption'],
                      'detectability'     => $this->detectability . $diff['detectability'],
                      'complexity'        => $this->complexity . $diff['complexity'],
                  ],
              ]);
    }
}