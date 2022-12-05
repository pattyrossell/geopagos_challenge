<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
use App\Models\PlayerSkill;

class Player extends Model
{
    use HasFactory;
    const STRENGH = 1;
    const VELOCITY = 2;
    const REACTIONTIME = 3;

    public function skills(){
        return $this->belongsToMany('App\Models\Skill', 'player_skill', 'player_id', 'skill_id')->withPivot('level');
    }
}
