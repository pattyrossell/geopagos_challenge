<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TournamentStoreRequest;
use App\Models\Player;
use App\Models\Tournament;
use App\Helper\TournamentGenerator;
use App\Http\Resources\TournamentResource;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->date && !$request->gender)
            $tournaments = Tournament::where('created_at', "like", $request->date.'%' )->get();
        elseif($request->gender && !$request->date)
            $tournaments = Tournament::where('gender', $request->gender)->get();
        elseif($request->date && $request->gender)
            $tournaments = Tournament::where('created_at', "like", $request->date.'%')->where('gender', $request->gender)->get();
        else
            $tournaments = Tournament::get();

        return TournamentResource::collection($tournaments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TournamentStoreRequest $request)
    {
        $gender = $request->input("gender");
        $players = Player::select('id')->where("gender", $gender)->get();
        $buildTournament = new TournamentGenerator($gender, $players);
        $champion = $buildTournament->getChampion();
        $tournament = new Tournament();
        $tournament->gender = $gender;
        $tournament->champion = $champion;
        $tournament->save();

        return new TournamentResource($tournament);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tournament $tournament)
    {
        return new TournamentResource($tournament);
    }
}
