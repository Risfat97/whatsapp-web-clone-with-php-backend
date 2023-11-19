<?php

assert(
    $argc === 3,
    "usage: make migration_up VERSION=Version123456789" . PHP_EOL . "make migration_down VERSION=Version123456789"
);

$commandArgs = [
    "upVersion" => [
        "command" => " execute ",
        "option" => " --up "
    ],
    "downVersion" => [
        "command" => " execute ",
        "option" => " --down "
    ]
];

$command = "/usr/bin/php8.2 " . __DIR__ . "/../vendor/bin/doctrine-migrations ";


if (isset($commandArgs[$argv[1]])) {
    $version = $argv[2] ?? '';
    $version = str_replace("--version=", "", $version);

    if ($version !== '') {
        $version = str_replace('%version%', $version, 'App\Migrations\%version%');
        $version = "'" . $version . "'";
    }

    echo "--------------------------------------------------------------------------------------------------------";
    echo PHP_EOL;

    $command .= $commandArgs[$argv[1]]["command"] . $version . $commandArgs[$argv[1]]["option"]
        . " --no-interaction "
        . " --configuration=" . __DIR__ . "/../config/migrations.php "
        . " --db-configuration=" . __DIR__ . "/../config/migrations-db.php";

    echo "Executing command: $command" . PHP_EOL;
    exec($command, $output, $return);

    echo "Result of migration: " . PHP_EOL;
    $output = array_values(array_filter($output));

    $outputStr = implode(PHP_EOL, $output) . PHP_EOL;
    echo $outputStr;

    if ($return !== 0) {
        throw new Exception($outputStr, $return);
    }
    echo PHP_EOL;
}