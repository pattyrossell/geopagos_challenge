<?php

namespace App\Factories;

use App\Helper\DefaultGameSimulator;
use App\Interfaces\GameSimulatorInterface;

class GameSimulatorFactory
{
    protected $simulators;

    public function __construct()
    {
        $this->simulators = [
            'direct' => DefaultGameSimulator::class,
        ];
    }

    public function make($type): GameSimulatorInterface
    {
        if (!array_key_exists($type, $this->simulators)) {
            throw new \Exception("Game simulator of type {$type} not found.");
        }

        return app($this->simulators[$type]);
    }
}
