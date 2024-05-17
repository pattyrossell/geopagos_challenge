<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tournament;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

class TournamentControllerTest extends TestCase
{
    /**
     * Test the index method of TournamentController.
     *
     * @return void
     */
    public function testIndexReturnsListOfTournaments()
    {
        $response = $this->get('/api/v1/tournaments');

        $response->assertJson(fn (AssertableJson $json) => $json->has('data'));
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * Test the store method of TournamentController.
     *
     * @return void
     */
    public function testStoreCreatesTournamentWithValidData()
    {
        $validData = [
            'gender' => 'm',
            'amountPlayers' => 16
        ];

        $response = $this->post('/api/v1/tournaments', $validData);

        $response->assertJson(fn (AssertableJson $json) => $json->has('data'));
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testStoreRejectsInvalidData()
    {
        $invalidData = [
            'gender' => 'p',
            'amountPlayers' => 15
        ];

        $response = $this->post('/api/v1/tournaments', $invalidData);

        $response->assertJsonStructure([
            'message',
            'error' => [
                'gender',
                'amountPlayers'
            ]
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test the show method of TournamentController.
     *
     * @return void
     */
    public function testShowReturnsTournamentIfExists()
    {
        $tournament = Tournament::factory()->create();

        $response = $this->get('/api/v1/tournaments/' . $tournament->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testShowReturns404IfTournamentDoesNotExist()
    {
        $response = $this->get('/api/v1/tournaments/kmp');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test filtering tournaments based on request parameters.
     *
     * @return void
     */
    public function testIndexFiltersTournamentsBasedOnRequestParameters()
    {
        $response = $this->getJson(route('tournaments.index', ['date' => '2024-05-17', 'gender' => 'm']));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data'));
    }

    /**
     * Test filtering tournaments based on invalid request parameters.
     *
     * @return void
     */
    public function testIndexFiltersTournamentsBasedOnInvalidRequestParameters()
    {
        $response = $this->getJson(route('tournaments.index', ['date' => '22-12-2023', 'gender' => 'k']));

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonStructure([
            'message',
            'error' => [
                'gender',
                'date'
            ]
        ]);
    }
}
