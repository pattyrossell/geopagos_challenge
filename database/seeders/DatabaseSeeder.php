<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use App\Models\Skill;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(Skill::get()->count() == 0){
            Skill::factory(1)->create(["value" => "Strenght"]);
            Skill::factory(1)->create(["value" => "Velocity of displacement"]);
            Skill::factory(1)->create(["value" => "Reaction time"]);
        }

        Player::factory(64)->create(["gender" => "f"])->each(function($player){
            $skills = Skill::select('id')->distinct()->get();
            foreach ($skills as $skill) {
                DB::table('player_skill')->insert([
                    "player_id" => $player->id,
                    "skill_id" => $skill->id,
                    "level" => rand(1, 100)
                ]);
            }
        });
        Player::factory(64)->create(["gender" => "m"])->each(function($player){
            $skills = Skill::select('id')->where('id', '!=', 3)->distinct()->get();
            foreach ($skills as $skill) {
                DB::table('player_skill')->insert([
                    "player_id" => $player->id,
                    "skill_id" => $skill->id,
                    "level" => rand(1, 100)
                ]);
            }
        });
    }             
}
