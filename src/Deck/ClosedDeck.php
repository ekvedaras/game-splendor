<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Deck;

use Ekvedaras\SpaceSim\Card;
use Ekvedaras\SpaceSim\Level;
use Webmozart\Assert\Assert;

/**
 * @template T of value-of<Level>
 */
final class ClosedDeck
{
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

    public function prepareOpenDeck(): OpenDeck
    {
        return new OpenDeck(
            closedDeck: $this,
            cards: [
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
    public function revealCard(): Card | DeckIsEmpty
    {
        return array_shift($this->cards) ?? new DeckIsEmpty();
    }

    /** @return Card<T> */
    private function mustRevealCard(): Card
    {
        $card = array_shift($this->cards);
        Assert::isInstanceOf($card, Card::class, 'No more cards in the deck!');
    }
}
