<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament;
use App\Helper\TournamentGenerator;
use App\Factories\GameSimulatorFactory;
use App\Repositories\TournamentRepository;

class TournamentService
{
    /**
     * @var GameSimulatorFactory
     */
    protected $gameSimulatorFactory;

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * Constructor of the class
     *
     * @param GameSimulatorFactory $gameSimulatorFactory
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct(GameSimulatorFactory $gameSimulatorFactory, TournamentRepository $tournamentRepository)
    {
        $this->gameSimulatorFactory = $gameSimulatorFactory;
        $this->tournamentRepository = $tournamentRepository;
    }

     /**
     *  Create new tournament.
     *
     * @param string $gender Gender of the players ('male' or 'female').
     * @param int|null $amountPlayers Number of players (optional).
     * @param string $simulatorType Type of game simulator ('direct' by default).
     * @return Tournament Instance of the created tournament.
     */
    public function createTournament($gender, $amountPlayers = null, $simulatorType = "direct")
    {
        $gameSimulator = $this->gameSimulatorFactory->make($simulatorType);
        $players = Player::select('id')->where('gender', $gender);

        if($amountPlayers) {
            $players->inRandomOrder()->take($amountPlayers);
        }

        $players = $players->get();

        $playerIds = $players->pluck('id')->toArray();

        $tournamentGenerator = new TournamentGenerator($gender, $players, $gameSimulator);
        $champion = $tournamentGenerator->getChampion();

        return $this->tournamentRepository->create($gender, $champion, $playerIds);
    }
}
