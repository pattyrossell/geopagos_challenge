<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Opcional: si usas datos de prueba sembrados en la base de datos
    }

    /**
     * Test retrieving a list of players.
     *
     * @return void
     */
    public function testIndexReturnsListOfPlayers()
    {
        $response = $this->get('/api/v1/players');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id', 
                    'name', 
                    'gender',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * Test retrieving a specific player.
     *
     * @return void
     */
    public function testShowReturnsSpecificPlayer()
    {
        $player = Player::factory()->create();

        $response = $this->get('/api/v1/players/' . $player->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $player->id,
                'name' => $player->name,
                'email' => $player->email
            ]
        ]);
    }

    public function testShowReturns404IfPlayerDoesNotExist()
    {
        $response = $this->get('/api/v1/players/1000');

        $response->assertJson([
            'message' => 'Record not found'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
