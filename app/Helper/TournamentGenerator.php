<?php

namespace App\Helper;

use App\Models\Player;
use Illuminate\Support\Collection;
use App\Factories\GameSimulatorFactory;
use App\Interfaces\GameSimulatorInterface;

class TournamentGenerator 
{
    /**
     * @var Collection
     */
    protected $players;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var int
     */
    protected $rounds;

    /**
     * @var int
     */
    protected $totalPlayers;

    /**
     * @var GameSimulatorInterface
     */
    protected $gameSimulator;

    /**
     * Constructor of the class.
     *
     * @param string $gender Gender of the players ('male' or 'female').
     * @param Collection $players Collection of Player instances.
     * @param GameSimulatorInterface $gameSimulator Instance of the game simulator.
     */
    public function __construct($gender, Collection $players, GameSimulatorInterface $gameSimulator)
    {
        $this->players = $players;
        $this->gender = $gender;
        $this->totalPlayers = log($players->count(), 2);
        $this->rounds = intval(round(log($players->count(), 2)));
        $this->gameSimulator = $gameSimulator;
    }

    /**
     * Get the players participating in the tournament.
     *
     * @return Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Get the gender of the tournament.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the champion of the tournament.
     *
     * @return mixed
     */
    public function getChampion()
    {
        return $this->buildTournament();
    }

    /**
     * Build the tournament structure and determine the champion.
     *
     * @return mixed
     */
    protected function buildTournament()
    {
        $games = $this->players->pluck('id')
            ->chunk(2)
            ->map(fn($group) => array_values($group->toArray()))
            ->values();

        $nextGames = $games;
        for ($round = 1; $round <= $this->rounds; $round++) {
            $nextGames = $this->getWinnersRound($round == 1 ? $games : $nextGames);
        }
        return $nextGames->flatten()->first();
    }

    /**
     * Get the winners of each round of the tournament.
     *
     * @param Collection $games Collection of games for a round.
     * @return Collection
     */
    protected function getWinnersRound(Collection $games)
    {
        $winners = $games->map(function ($game) {
            return $this->gameSimulator->simulate(
                Player::find($game[0]),
                Player::find($game[1])
            )->id;
        });
        return $winners->chunk(2)
            ->map(fn($group) => array_values($group->toArray()))
            ->values();
    }
}