<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Services\TournamentService;
use App\Repositories\TournamentRepository;
use App\Http\Requests\TournamentIndexRequest;
class TournamentController extends Controller
{
    /**
     * @var TournamentService
     */
    protected $tournamentService;

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository,TournamentService $tournamentService)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentService = $tournamentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\TournamentIndexRequest $request
     * @return TournamentResource A collection of Player resources.
     */
    public function index(TournamentIndexRequest $request)
    {
        $tournaments = $this->tournamentRepository->getTournaments($request->date, $request->gender);
        return TournamentResource::collection($tournaments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TournamentStoreRequest $request
     * @return TournamentResource
     */
    public function store(TournamentStoreRequest $request)
    {
        $tournament = $this->tournamentService->createTournament($request->input("gender"), $request->input("amountPlayers"));
        return new TournamentResource($tournament);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tournament $tournament
     * @return TournamentResource
     */
    public function show(Tournament $tournament)
    {
        return new TournamentResource($tournament);
    }
}
