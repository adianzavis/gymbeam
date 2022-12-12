<?php

namespace App\Console;

require_once __DIR__ .'/../../vendor/autoload.php';

try {
    $commandName = '';

    if (isset($argv[1])) {
        $commandName = $argv[1];
    } else {
        throw new \Exception("No command has been selected.");
    }

    $provider = new CommandProvider();
    $command = $provider->getCommand($commandName);
    (new $command())->run();

} catch (\Throwable $e) {
    print_r($e->getMessage());
    die();
}
