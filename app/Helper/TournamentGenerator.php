<?php

namespace App\Helper;

use App\Models\Player;

class TournamentGenerator 
{
    protected $players;
    protected $gender;
    protected $rounds;
    protected $totalPlayers;

    public function __construct($gender, $players)
    {
        $this->players = $players;
        $this->gender = $gender;
        $this->totalPlayers = log($players->count());
        $this->rounds = intval(round(log($players->count(), 2)));
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getChampion()
    {
        return $this->buildTournament();
    }

    public function buildTournament()
    {
        $games = $this->players->pluck('id')->chunk(2);
        $gamesSorted = $this->sortGames($games);
        $nextGames = collect();
        $champion = "";
        for($i = 1; $i <= $this->rounds; $i++){  
            $nextGames = $this->sortGames($nextGames);
            $lastRound = $i == $this->rounds ? true : false;
            $nextGames = $i == 1 ? $this->getWinnersRound($gamesSorted) : $this->getWinnersRound($nextGames);

            if($i == $this->rounds-1){
                $champion = $this->getWinnersRound($nextGames,$lastRound);
            }
        }
        return $champion->last()->last();
    }

    public function getWinnersRound($games, $lastRound = false)
    {
        $nextGames = [];
        foreach ($games->toArray() as $key => $value) {
            $winner = $this->getWinner($value[0], $value[1]);
            array_push($nextGames, $winner);
        }

        $nextGames = collect($nextGames);
        return $nextGames->pluck('id')->chunk(2);
    }

    public function getWinner($player1, $player2)
    {
        $player1 = Player::find($player1);
        $pointsPlayer1 = $this->sumOfSkills($player1->skills);

        $player2 = Player::find($player2);
        $pointsPlayer2 = $this->sumOfSkills($player2->skills);

        return $this->simulateGame($pointsPlayer1, $pointsPlayer2, $player1, $player2);
    }
    
    public function sumOfSkills($skills)
    {
        $sum = 0;
        foreach ($skills as $key) {
            $sum = $sum + $key->pivot->level;
        }
        return $sum;
    }
    
    public function simulateGame($pointsPlayer1, $pointsPlayer2, $player1, $player2)
    {
        if($pointsPlayer1 == $pointsPlayer2)
            return $this->getWinnerByLuck($player1, $player2);
        else
            return $pointsPlayer1 > $pointsPlayer2 ? $player1 : $player2;
    }

    public function getWinnerByLuck($player1, $player2)
    {
        $luckPlayer1 = rand(1, 100);
        $luckPlayer2 = rand(1, 100);
        if($luckPlayer1 != $luckPlayer2)
            return $luckPlayer1 > $luckPlayer2 ? $player1 : $player2;
        else
            return $this->getWinnerByLuck($player1, $player2);
    }
    
    public function sortGames($games, $a =0){
        return $games->map(function($chunk) {
            return $chunk->values();
        });
    }
}