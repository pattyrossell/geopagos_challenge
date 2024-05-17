<?php
namespace App\Helper;

use App\Models\Player;
use App\Interfaces\GameSimulatorInterface;

class DefaultGameSimulator implements GameSimulatorInterface
{
    /**
     * Simulate a game between two players based on their skills.
     *
     * @param Player $player1 The first player.
     * @param Player $player2 The second player.
     * @return Player The winner of the simulated game.
     */
    public function simulate(Player $player1, Player $player2): Player
    {
        $pointsPlayer1 = $this->sumOfSkills($player1->skills);
        $pointsPlayer2 = $this->sumOfSkills($player2->skills);

        return $this->determineWinner($pointsPlayer1, $pointsPlayer2, $player1, $player2);
    }

    /**
     * Calculate the sum of skills for a player.
     *
     * @param mixed $skills The skills of the player.
     * @return int The sum of skill levels.
     */
    protected function sumOfSkills($skills)
    {
        return $skills->sum(fn($skill) => $skill->pivot->level);
    }

    /**
     * Determine the winner of the game based on skill points or luck in case of a tie.
     *
     * @param int $pointsPlayer1 The skill points of player 1.
     * @param int $pointsPlayer2 The skill points of player 2.
     * @param Player $player1 The first player.
     * @param Player $player2 The second player.
     * @return Player The winner of the game.
     */
    protected function determineWinner($pointsPlayer1, $pointsPlayer2, Player $player1, Player $player2)
    {
        if ($pointsPlayer1 == $pointsPlayer2) {
            return $this->getWinnerByLuck($player1, $player2);
        }
        return $pointsPlayer1 > $pointsPlayer2 ? $player1 : $player2;
    }

    /**
     * Determine the winner of the game by luck in case of a tie in skill points.
     *
     * @param Player $player1 The first player.
     * @param Player $player2 The second player.
     * @return Player The winner of the game.
     */
    protected function getWinnerByLuck(Player $player1, Player $player2)
    {
        do {
            $luckPlayer1 = rand(1, 100);
            $luckPlayer2 = rand(1, 100);
        } while ($luckPlayer1 == $luckPlayer2);

        return $luckPlayer1 > $luckPlayer2 ? $player1 : $player2;
    }
}