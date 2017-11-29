<?php
require_once ("config.php");
require_once ("lib/lib_database.php");
require_once ("lib/lib_telegram.php");
require_once ("model/UnknownCommand.class.php");
require_once ("model/LocationCommand.class.php");
require_once ("model/RadiusCommand.class.php");
require_once ("model/StartCommand.class.php");
require_once ("model/HelpCommand.class.php");

// lettura body http trasmesso da server telegram
$content = file_get_contents("php://input");

// decodifica del body testuale in json
$value = json_decode($content);

$startElement = new StartCommand();
$radiusElement = new RadiusCommand();
$locationElement = new LocationCommand();
$helpElement = new HelpCommand();
$errorElement = new UnknownCommand();

$startElement->setNext($radiusElement);
$radiusElement->setNext($locationElement);
$locationElement->setNext($helpElement);
$helpElement->setNext($errorElement);

$startElement->handleValue($value);

return 0;
