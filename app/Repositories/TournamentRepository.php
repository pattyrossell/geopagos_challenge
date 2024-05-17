<?php

namespace App\Repositories;

use App\Models\Tournament;

class TournamentRepository
{
    /**
     * Get tournaments filtered by date and/or gender.
     *
     * @param string|null $date The date in 'Y-m-d' format (optional).
     * @param string|null $gender The gender of the tournaments ('male' or 'female') (optional).
     * @return \Illuminate\Database\Eloquent\Collection A collection of Tournament instances.
     */
    public function getTournaments($date = null, $gender = null)
    {
        $query = Tournament::query();

        if ($date) {
            $query->where('created_at', 'like', $date . '%');
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        return $query->get();
    }

    /**
     * Create a new tournament record in the database.
     *
     * @param string $gender The gender of the tournament ('male' or 'female').
     * @param int $champion The champion of the tournament.
     * @param array $playerIds The IDs of the contestants.
     * @return Tournament The created Tournament instance.
     */
    public function create($gender, $champion, $playerIds)
    {
        $tournament = new Tournament();
        $tournament->gender = $gender;
        $tournament->champion = $champion;
        $tournament->contestants = json_encode($playerIds);
        $tournament->save();

        return $tournament;
    }
}
