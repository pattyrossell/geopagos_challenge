<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository
{
    /**
     * Retrieve all players from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of all Player instances.
     */
    public function getAllPlayers()
    {
        return Player::all();
    }

    /**
     * Retrieve a specific player from the database by its id.
     *
     * @param int $id The id of the player.
     * @return Player The retrieved Player instance.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the player with the given id is not found.
     */
    public function getPlayer($id)
    {
        return Player::findOrFail($id);
    }
}