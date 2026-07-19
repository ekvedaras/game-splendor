<?php

declare(strict_types=1);

namespace Ekvedaras\SpaceSim\Actions;

use Ekvedaras\SpaceSim\Game;
use Ekvedaras\SpaceSim\Player;

interface Action
{
    public function name(): string;

    public function input(Game $game): PlayerInput;

    public function allowed(Game $game, Player $player, PlayerInput $input): bool;

    public function perform(Game $game, Player $player, PlayerInput $input): void;
}
