<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Deck\ClosedDeck;
use Ekvedaras\SpaceSim\Deck\OpenDeck;
use Webmozart\Assert\Assert;

final class Game
{
    /** @var OpenDeck<Level::First> */
    private(set) readonly OpenDeck $firstLevelOpenCards;

    /** @var OpenDeck<Level::Second> */
    private(set) readonly OpenDeck $secondLevelOpenCards;

    /** @var OpenDeck<Level::Third> */
    private(set) readonly OpenDeck $thirdLevelOpenCards;

    public function __construct(
        /** @var list<Player> */
        private(set) readonly array $players,
        /** @var ClosedDeck<Level::First> */
        private(set) readonly ClosedDeck $firstLevelDeck,
        /** @var ClosedDeck<Level::Second> */
        private(set) readonly ClosedDeck $secondLevelDeck,
        /** @var ClosedDeck<Level::Third> */
        private(set) readonly ClosedDeck $thirdLevelDeck,
    )
    {
        Assert::countBetween($this->players, 1, 4);
        $this->firstLevelOpenCards = $this->firstLevelDeck->prepareOpenDeck();
        $this->secondLevelOpenCards = $this->secondLevelDeck->prepareOpenDeck();
        $this->thirdLevelOpenCards = $this->thirdLevelDeck->prepareOpenDeck();
    }
}
