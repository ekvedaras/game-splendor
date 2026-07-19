<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Game;

use Ekvedaras\SpaceSim\Player;

use function Termwind\ask;

final readonly class BuyCard implements Action
{
    public function name(): string
    {
        return 'Buy card';
    }

    public function input(Game $game): PlayerInput
    {
        return new PlayerInput(ask('Which level?').'|'.ask('Which card?'));
    }

    public function allowed(Game $game, Player $player, PlayerInput $input): bool
    {
        [$level, $position] = explode('|', $input->input);

        return match ($level) {
            '1' => $game->firstLevelOpenCards->cards[$position]->canBeBought($player->resources),
            '2' => $game->secondLevelOpenCards->cards[$position]->canBeBought($player->resources),
            '3' => $game->thirdLevelOpenCards->cards[$position]->canBeBought($player->resources),
        };
    }

    public function perform(Game $game, Player $player, PlayerInput $input): void
    {
        [$level, $position] = explode('|', $input->input);

        match ($level) {
            '1' => $player->takeCard((int) $position, $game->firstLevelOpenCards),
            '2' => $player->takeCard((int) $position, $game->secondLevelOpenCards),
            '3' => $player->takeCard((int) $position, $game->thirdLevelOpenCards),
        };
    }
}
