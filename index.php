<?php
require_once ("config.php");
require_once ("lib/lib_database.php");
require_once ("lib/lib_telegram.php");
require_once ("model/UnknownCommand.class.php");
require_once ("model/LocationCommand.class.php");
require_once ("model/RadiusCommand.class.php");
require_once ("model/StartCommand.class.php");
require_once ("model/HelpCommand.class.php");
require_once ("model/BetCommand.php");
require_once ("model/IelloCommand.php");

// lettura body http trasmesso da server telegram
$content = file_get_contents("php://input");

/*$content = '{"update_id":68598512,
"message":{"message_id":1107,"from":{"id":337879368,"is_bot":false,"first_name":"Andrea","username":"andrea9671","language_code":"it"},"chat":{"id":337879368,"first_name":"Andrea","username":"andrea9671","type":"private"},"date":1511977865,"location":{"latitude":43.718835,"longitude":12.866447}}}';*/

/*$content = '{"update_id":68598514,
"message":{"message_id":1110,"from":{"id":337879368,"is_bot":false,"first_name":"Andrea","username":"andrea9671","language_code":"it"},"chat":{"id":337879368,"first_name":"Andrea","username":"andrea9671","type":"private"},"date":1511978338,"text":"/raggio 0","entities":[{"offset":0,"length":6,"type":"bot_command"}]}}';*/
// decodifica del body testuale in json
$value = json_decode($content);

$startElement = new StartCommand();
$radiusElement = new RadiusCommand();
$helpElement = new HelpCommand();
$locationElement = new LocationCommand();
$helpElement = new HelpCommand();
$errorElement = new UnknownCommand();
$betElement = new BetCommand();
$ielloElement = new IelloCommand();

$startElement->setNext($radiusElement);

$radiusElement->setNext($helpElement);
$helpElement->setNext($locationElement);
$locationElement->setNext($betElement);
$betElement->setNext($ielloElement);
$ielloElement->setNext($errorElement);

$startElement->handleValue($value);

return 0;
