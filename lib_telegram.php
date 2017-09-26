<?php

require_once("config.php");

function send_message($chat_id, $text)
{
	file_put_contents("vardump.txt", (TELEGRAM_URL_SEND_MESSAGE . "?chat_id=" . $chat_id . "&text=" . urlencode($text)) . PHP_EOL, FILE_APPEND);
	$curl = curl_init((TELEGRAM_URL_SEND_MESSAGE . "?chat_id=" . $chat_id . "&text=" . urlencode($text)));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($curl);
	file_put_contents("vardump.txt", serialize($result), FILE_APPEND);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	if($httpCode == 200)
		return json_decode($result);
	else
		return false;
}

function send_location($chat_id, $latitude, $longitude)
{
	$curl = curl_init((TELEGRAM_URL_SEND_LOCATION . "?chat_id=" . $chat_id . "&latitude=" . $latitude . "&longitude=" . $longitude));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	if($httpCode == 200)
		return json_decode($result);
	else
		return false;
}

?>
