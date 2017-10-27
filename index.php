<?php
require_once("config.php");
require_once("lib/lib_database.php");
require_once("lib/lib_telegram.php");
require_once ("model/LocationCommand.class.php");
require_once ("model/RadiusCommand.php");
require_once ("model/StartCommand.php");

// lettura body http trasmesso da server telegram
$content = file_get_contents("php://input");

// decodifica del body testuale in json
$value = json_decode($content);

$startChain = new StartCommand();
$radiusChain = new RadiusCommand();
$locationChain = new LocationCommand();

$startChain->setNext($radiusChain);
$radiusChain->setNext($locationChain);

$startChain->handleValue($value);

return 0;
