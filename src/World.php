<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Actions\Action;
use Ekvedaras\SpaceSim\Actions\ChangeDoctrine;
use Ekvedaras\SpaceSim\Actions\QuitGame;
use Ekvedaras\SpaceSim\Doctrines\Doctrine;

use Ekvedaras\SpaceSim\Doctrines\OrbitalInfrastructure;

use Ekvedaras\SpaceSim\Doctrines\PlanetaryIndustry;

use function Laravel\Prompts\table;

final class World
{
    /** @var array<non-empty-string, Planet> */
    private(set) array $planets = [];

    public int $energyProduction {
        get => array_sum(array_map(fn (Planet $planet) => $planet->energyProduction, $this->planets));
    }

    public int $energyConsumption {
        get => (int)array_sum(array_map(fn (Planet $planet) => $planet->energyConsumption, $this->planets));
    }

    public bool $allowChangingDoctrine = false;

    public function __construct(
        public Doctrine $doctrine,
        private(set) int $energy,
    ) {
        $this->planets[] = new Planet(
            name: 'Earth',
            world: $this,
            population: 2,
        );
    }

    public function tick(): void
    {
        $this->doctrine->tick($this);
        $this->generateEnergy($this->energyProduction - $this->energyConsumption);
    }

    public function generateEnergy(int $amount): void
    {
        $this->energy += $amount;
    }

    public function consumeEnergy(int $amount): void
    {
        $this->energy -= $amount;
    }

    /** @return list<Action> */
    public function availableActions(): array
    {
        $actions = [
            ...($this->allowChangingDoctrine ? [
                new ChangeDoctrine(new OrbitalInfrastructure()),
                new ChangeDoctrine(new PlanetaryIndustry()),
            ] : []),
            ...$this->doctrine->availableActions($this),
            new QuitGame(),
        ];

        $keys = array_map(strval(...), $actions);

        return array_combine($keys, $actions);
    }

    public function print(): void
    {
        table(['Doctrine', 'Energy', 'Population', 'Energy production', 'Energy concumption'],
              [
                  [
                      'doctrine'          => $this->doctrine::class,
                      'energy'            => $this->energy,
                      'energyProduction'  => $this->energyProduction,
                      'energyConsumption' => $this->energyConsumption,
                  ],
              ]);
    }
}