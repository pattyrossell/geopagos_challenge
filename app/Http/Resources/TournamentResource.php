<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "idTournament" => $this->id,
            "gender" => $this->gender,
            "champion" => $this->champion,
            "contestants" => $this->contestants,
            "name" => $this->player->name,
            "created_at" => $this->created_at
        ];
    }
}
