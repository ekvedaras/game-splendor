<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Deck\ClosedDeck;
use Ekvedaras\SpaceSim\Deck\OpenDeck;
use Ekvedaras\SpaceSim\Resources\Resource;
use Ekvedaras\SpaceSim\Resources\Stack;
use Ekvedaras\SpaceSim\Resources\StacksOfResources;
use Webmozart\Assert\Assert;

use function Laravel\Prompts\table;

final readonly class Game
{
    /** @var OpenDeck<Level::First> */
    private(set) OpenDeck $firstLevelOpenCards;

    /** @var OpenDeck<Level::Second> */
    private(set) OpenDeck $secondLevelOpenCards;

    /** @var OpenDeck<Level::Third> */
    private(set) OpenDeck $thirdLevelOpenCards;

    public function __construct(
        /** @var list<Player> */
        private(set) array $players,
        /** @var ClosedDeck<Level::First> */
        private(set) ClosedDeck $firstLevelDeck,
        /** @var ClosedDeck<Level::Second> */
        private(set) ClosedDeck $secondLevelDeck,
        /** @var ClosedDeck<Level::Third> */
        private(set) ClosedDeck $thirdLevelDeck,
        private(set) StacksOfResources $resourcesOnTheTable = new StacksOfResources(
            blackStack: new Stack(Resource::Black, 4),
            whiteStack: new Stack(Resource::White, 4),
            redStack: new Stack(Resource::Red, 4),
            blueStack: new Stack(Resource::Blue, 4),
            greenStack: new Stack(Resource::Green, 4),
            yellowStack: new Stack(Resource::Yellow, 2),
        ),
    )
    {
        Assert::countBetween($this->players, 1, 4);

        $this->firstLevelOpenCards = $this->firstLevelDeck->prepareOpenDeck();
        $this->secondLevelOpenCards = $this->secondLevelDeck->prepareOpenDeck();
        $this->thirdLevelOpenCards = $this->thirdLevelDeck->prepareOpenDeck();
    }

    public function print(): void
    {
        table([
            [$this->thirdLevelDeck->toCliString(), ...$this->thirdLevelOpenCards->toCardCliStrings()],
            [$this->secondLevelDeck->toCliString(), ...$this->secondLevelOpenCards->toCardCliStrings()],
            [$this->firstLevelDeck->toCliString(), ...$this->firstLevelOpenCards->toCardCliStrings()],
              ]);

        $this->resourcesOnTheTable->print();

        foreach ($this->players as $player) {
            $player->print();
        }
    }
}
