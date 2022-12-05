<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class Tournament extends Model
{
    use HasFactory;

    public function player()
    {
        return $this->hasOne(Player::class,'id','champion');
    }
}
