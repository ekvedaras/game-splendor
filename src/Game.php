<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim;

use Ekvedaras\SpaceSim\Actions\Action;
use Ekvedaras\SpaceSim\Actions\BuyCard;
use Ekvedaras\SpaceSim\Deck\ClosedDeck;
use Ekvedaras\SpaceSim\Deck\OpenDeck;
use Ekvedaras\SpaceSim\Resources\Resource;
use Ekvedaras\SpaceSim\Resources\Stack;
use Ekvedaras\SpaceSim\Resources\StacksOfResources;
use Webmozart\Assert\Assert;

use function Laravel\Prompts\info;
use function Laravel\Prompts\table;

final class Game
{
    /** @var OpenDeck<Level::First> */
    private(set) readonly OpenDeck $firstLevelOpenCards;

    /** @var OpenDeck<Level::Second> */
    private(set) readonly OpenDeck $secondLevelOpenCards;

    /** @var OpenDeck<Level::Third> */
    private(set) readonly OpenDeck $thirdLevelOpenCards;

    public Player $currentPlayer { get => current($this->players); }

    public function __construct(
        /** @var list<Player> */
        private(set) array $players,
        /** @var ClosedDeck<Level::First> */
        private(set) readonly ClosedDeck $firstLevelDeck,
        /** @var ClosedDeck<Level::Second> */
        private(set) readonly ClosedDeck $secondLevelDeck,
        /** @var ClosedDeck<Level::Third> */
        private(set) readonly ClosedDeck $thirdLevelDeck,
        private(set) readonly StacksOfResources $resourcesOnTheTable = new StacksOfResources(
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
        reset($this->players);

        $this->firstLevelOpenCards = $this->firstLevelDeck->prepareOpenDeck();
        $this->secondLevelOpenCards = $this->secondLevelDeck->prepareOpenDeck();
        $this->thirdLevelOpenCards = $this->thirdLevelDeck->prepareOpenDeck();
    }

    /** @return list<Action> */
    public function actions(): array
    {
        $buyCard = new BuyCard();
        return [
            $buyCard::class => $buyCard->name(),
        ];
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

        info("Turn: {$this->currentPlayer->name}");
    }
}
