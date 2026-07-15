<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

use Ekvedaras\SpaceSim\Card;
use Ekvedaras\SpaceSim\Cost\MultipleResources;
use Ekvedaras\SpaceSim\Cost\Resources;
use Ekvedaras\SpaceSim\Level;
use Ekvedaras\SpaceSim\Resource;
use Webmozart\Assert\Assert;

/**
 * @template T of value-of<Level>
 */
final class ClosedDeck
{
    public int $remainingCards { get => count($this->cards); }

    public function __construct(
        /** @var T */
        public readonly Level $level,
        /** @var list<Card<T>> */
        private(set) array $cards = [],
    ) {
        Assert::allIsInstanceOf($cards, Card::class);

        foreach ($this->cards as $card) {
            Assert::same($card->level, $this->level);
        }
    }

    public function shuffle(): self
    {
        shuffle($this->cards);

        return $this;
    }

    public function prepareOpenDeck(): OpenDeck
    {
        return new OpenDeck(
            closedDeck: $this,
            cards:      [
                            $this->revealCard(),
                            $this->revealCard(),
                            $this->revealCard(),
                            $this->revealCard(),
                        ],
        );
    }

    /**
     * @return Card<T>|DeckIsEmpty
     */
    public function revealCard(): Card|DeckIsEmpty
    {
        return array_shift($this->cards) ?? new DeckIsEmpty();
    }

    public function toCliString(): string
    {
        return (
        $this->remainingCards === 0 ? "\e[0;30m" : ''
        )."{$this->level->toCliString()} {$this->remainingCards}\e[0;30m";
    }

    /** @return Card<T> */
    private function mustRevealCard(): Card
    {
        $card = array_shift($this->cards);
        Assert::isInstanceOf($card, Card::class, 'No more cards in the deck!');
    }

    public static function forFirstLevel(): self
    {
        return new self(
            level: Level::First,
            cards: [
                   new Card(Level::First, Resource::Black, Resource::oneOfAll(), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 0, 1, 0, 1), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 2, 0, 0, 2), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(1, 0, 3, 0, 1), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 0, 0, 0, 3), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 1, 1, 2, 1), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 2, 1, 2, 0), 0),
                   new Card(Level::First, Resource::Black, Resource::cost(0, 0, 0, 0, 4), 1),
                //...
                   ],
        );
    }

    public static function forSecondLevel(): self
    {
        return new self(
            level: Level::Second,
            cards: [
                       new Card(Level::Second, Resource::Black, Resource::oneOfAll(), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 0, 1, 0, 1), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 2, 0, 0, 2), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(1, 0, 3, 0, 1), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 0, 0, 0, 3), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 1, 1, 2, 1), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 2, 1, 2, 0), 0),
                       new Card(Level::Second, Resource::Black, Resource::cost(0, 0, 0, 0, 4), 1),
                   ],
        );
    }

    public static function forThirdLevel(): self
    {
        return new self(
            level: Level::Third,
            cards: [
                       new Card(Level::Third, Resource::Black, Resource::cost(0, 3, 3, 3, 5), 3),
                       new Card(Level::Third, Resource::Black, Resource::cost(0, 0, 0, 7, 0), 4),
                       new Card(Level::Third, Resource::Black, Resource::cost(3, 0, 6, 0, 3), 4),
                       new Card(Level::Third, Resource::Black, Resource::cost(3, 0, 7, 0, 0), 5),
                   ],
        );
    }
}
