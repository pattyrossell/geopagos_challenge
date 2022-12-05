<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class TournamentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/v1/tournament/', ['gender' => 'm']);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data'));
        $response->assertStatus(201);

        $response = $this->get('/api/v1/tournament/');
        $response->assertJson(fn (AssertableJson $json) => $json->has('data'));
        $response->assertStatus(200);

    }
}
