<?php

declare(strict_types=1);

require "vendor/autoload.php";

use PayHero\Calculator\Input\Event;
use PayHero\Calculator\Input\InputOutputHandler;
use PayHero\Calculator\Person\PersonHandler;
use PayHero\Calculator\Service\WeekManager;

$filePath = $argv[1];
$file = fopen($filePath, 'r');

$config = include 'config.php';

$handler = new InputOutputHandler();
$users = array();
$numberOfTransactions = array();
$lastWeek = '';

while (($line = fgetcsv($file)) !== FALSE) {
    $e = new Event($line);
    $newDate = $e->getData()["date"];

    if (! WeekManager::checkIsSameWeek($lastWeek, $newDate))
    {
        PersonHandler::resetTransactionAmounts();
        PersonHandler::resetUserTransactionNumber();
    }

    $result = $handler::handle($e, $config);
    $lastWeek = $newDate;

    print($result.PHP_EOL);
}
fclose($file);
