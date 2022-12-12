<?php

namespace App\Console;

use App\Console\Commands\CommandInterface;
use App\Console\Commands\MostUsedWordCommand;

class CommandProvider {

    /*
     * Register available commands here
     */
    private array $commands = [
        'most-used-word' => MostUsedWordCommand::class,
    ];

    public function getCommand(string $name): CommandInterface {
        if ($name === '' || !isset($this->commands[$name])) {
            throw new \Exception('No command found');
        }

        return new $this->commands[$name]();
    }
}
