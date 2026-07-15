<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

use Ekvedaras\SpaceSim\Card;
use Ekvedaras\SpaceSim\Level;
use Webmozart\Assert\Assert;

/**
 * @template T of value-of<Level>
 */
final class OpenDeck implements Deck
{
    public Level $level { get => $this->closedDeck->level; }

    public function __construct(
        /** @var ClosedDeck<T> */
        private(set) readonly ClosedDeck $closedDeck,
        /** @var array{0: Card<T>|OpenSlot, 1: Card<T>|OpenSlot, 2: Card<T>|OpenSlot, 3: Card<T>|OpenSlot} */
        private(set) array $cards = [],
    ) {
        Assert::allIsInstanceOf($cards, Card::class);

        foreach ($this->cards as $card) {
            Assert::same($card->level, $this->level);
        }
    }

    /**
     * @var int<0, 3> $position
     * @return Card<T>|NoCardInSlot
     */
    public function takeCard(int $position): Card|NoCardInSlot
    {
        $card = $this->cards[$position];
        if ($card instanceof OpenDeck) {
            return new NoCardInSlot($position);
        }

        $revealedCard = $this->closedDeck->revealCard();

        $this->cards[$position] = match ($revealedCard::class) {
            Card::class => $revealedCard,
            DeckIsEmpty::class => new OpenSlot(),
        };

        return $card;
    }

    public function toCliString(): string
    {
        return implode(' ', $this->toCardCliStrings());
    }

    /** @return list<string> */
    public function toCardCliStrings(): array
    {
        return array_map(fn (Card $card): string => $card->toCliString(), $this->cards);
    }
}
