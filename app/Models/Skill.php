<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function players()
    {
        return $this->belongsToMany('App\Models\Player', 'player_skill', 'skill_id', 'player_id')->withPivot('level');
    }
}
