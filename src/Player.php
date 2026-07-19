<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Deck\OpenDeck;
use Ekvedaras\SpaceSim\Resources\Stack;
use Ekvedaras\SpaceSim\Resources\StacksOfResources;
use Ekvedaras\SpaceSim\Bonuses\Bonus;
use Webmozart\Assert\Assert;

use function Laravel\Prompts\info;
use function Laravel\Prompts\table;

final class Player
{
    /** @var list<Card<Level>> */
    private(set) array $cards = [];

    /** @var list<Bonus> */
    private(set) array $bonuses = [];

    public int $points {
        get => array_sum([
                             ...array_map(fn(Card $card) => $card->points, $this->cards),
                             ...array_map(fn(Bonus $bonus) => $bonus->points, $this->bonuses),
                         ]);
    }

    public function __construct(
        /** @var non-empty-string */
        public readonly string $name,
        public readonly StacksOfResources $resources = new StacksOfResources(),
    ) {
        Assert::notEmpty($name);
    }

    public function takeOneResource(Stack $from): self
    {
        $this->resources->add($from->takeOne());
        return $this;
    }

    public function takeTwoResources(Stack $from): self
    {
        $this->resources->add($from->takeTwo());
        return $this;
    }

    public function takeCard(int $position, OpenDeck $from): self
    {
        // todo: may be an open stop
        Assert::true($from->cards[$position]->canBeBought($this->resources), "Not enought resources to by the card");

        $card = $from->takeCard($position);
        Assert::isInstanceOf($card, Card::class, 'No card in such position');

        $this->cards[] = $card;

        return $this;
    }

    public function print(): void
    {
        info("{$this->name} [{$this->points}]");

        $this->resources->print();

        table([
                  array_map(fn(Card $card) => $card->toCliString(), $this->cards),
              ]);
    }
}
