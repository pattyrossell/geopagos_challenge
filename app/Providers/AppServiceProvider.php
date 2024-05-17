<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PlayerRepository;
use App\Repositories\TournamentRepository;
use App\Helper\DefaultGameSimulator;
use App\Services\TournamentService;
use App\Helper\TournamentGenerator;
use App\Interfaces\GameSimulatorInterface;
use App\Factories\GameSimulatorFactory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlayerRepository::class);
        $this->app->singleton(TournamentRepository::class);
        $this->app->singleton(GameSimulatorFactory::class);
        $this->app->singleton(TournamentService::class, function ($app) {
            return new TournamentService(
                $app->make(GameSimulatorFactory::class),
                $app->make(TournamentRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}