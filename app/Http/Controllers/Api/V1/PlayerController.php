<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Http\Resources\PlayerResource;
use App\Repositories\PlayerRepository;

class PlayerController extends Controller
{
    /**
     * @var PlayerRepository
     */
    protected $playerRepository;

    /**
     * PlayerController constructor.
     *
     * @param PlayerRepository $playerRepository Instance of PlayerRepository.
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Display a listing of the players.
     *
     * @return PlayerResource A collection of Player resources.
     */
    public function index()
    {
        $players = $this->playerRepository->getAllPlayers();
        return PlayerResource::collection($players);
    }


    /**
     * Display the specified player.
     *
     * @param Player $player The player to display.
     * @return PlayerResource The resource representing the player.
     */
    public function show(Player $player)
    {
        return new PlayerResource($player);
    }
}
