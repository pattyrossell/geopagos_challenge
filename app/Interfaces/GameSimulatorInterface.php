<?php
namespace App\Interfaces;

use App\Models\Player;

interface GameSimulatorInterface
{
    /**
     * Simulate a game between two players.
     *
     * @param Player $player1 The first player.
     * @param Player $player2 The second player.
     * @return Player The winner of the simulated game.
     */
    public function simulate(Player $player1, Player $player2): Player;
}