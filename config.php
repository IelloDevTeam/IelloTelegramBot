<?php


// settaggio database
define('DATABASE_HOST','localhost');
define('DATABASE_NAME','...');
define('DATABASE_USERNAME','...');
define('DATABASE_PASSWORD','...');

define('TELEGRAM_BOT_TOKEN', '...');
define('TELEGRAM_BASE_URL', 'https://api.telegram.org/bot');
define('TELEGRAM_URL', TELEGRAM_BASE_URL . TELEGRAM_BOT_TOKEN);
define('TELEGRAM_URL_SEND_MESSAGE', TELEGRAM_URL . "/sendMessage");
define('TELEGRAM_URL_SEND_LOCATION', TELEGRAM_URL . "/sendLocation");

define('IELLO_BASE_URL', 'http://localhost:4000/');
define('IELLO_PARKING_URL', IELLO_BASE_URL . 'iello/v1/parking');


?>
