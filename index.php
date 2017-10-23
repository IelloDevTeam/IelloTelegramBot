<?php
require_once("config.php");
require_once("lib_database.php");
require_once("lib_telegram.php");

$content = file_get_contents("php://input");
$value = json_decode($content);

//file_put_contents("dump.txt", $content);
//file_put_contents("value.txt", serialize($value));
$chat_id = $value->message->chat->id;
$user_id = $value->message->from->id;

//file_put_contents("dump.txt", serialize($chat_id . "   " . $user_id));

//send_message($chat_id, "ciaoo");

if(isset($value->message->location))
{
  $lat = $value->message->location->latitude;
  $lon = $value->message->location->longitude;

  $db_raggio = db_row_query("SELECT raggio FROM Users WHERE user_id = $user_id");

  // richiesta alle api IELLO.
  $curl_api = curl_init(IELLO_PARKING_URL . "?latitude=$lat&longitude=$lon" . ((!$db_raggio) ? '' : "&radius=" . $db_raggio[0]));
  curl_setopt($curl_api, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($curl_api);
  $httpCode = curl_getinfo($curl_api, CURLINFO_HTTP_CODE);
  curl_close($curl_api);

  if($httpCode == 200)
  {
    $parking = json_decode($result);
    if($parking->message->parking_count > 0)
    {
      send_message($chat_id, "Ecco i parcheggi nelle tue vicinanze");
      foreach ($parking->message->parking as $index => $value) {
        send_location($chat_id, $value->latitude $value->longitude);
      }
    }
    else
    {
      send_message($chat_id, "Non ho trovato nessun parcheggio nelle tue vicinanze");
    } // chiude parking_count
  } // chiude httpCode
}
else if(isset($value->message->text))
{
  if(strpos($value->message->text, "/start") == 0)
  {
    send_message($chat_id, "Benvenuto!");
  }
  else if(strpos($value->message->text, "/raggio") == 0){
    echo ('Received /raggio command!\n');
    // estraggo raggio
    $raggio = substr($value->message->text, 7);
    if(raggio && !empty($raggio) && is_numeric($raggio))
    {
      if($raggio > 0)
      {
        db_perform_action("REPLACE INTO Users(user_id, raggio) VALUES($user_id, $raggio)");
	send_message($chat_id, "Ok, quando vorrai richercherò parcheggi ad una distanza massima di: " . $raggio . "m");
      }
      else
      {
        send_location($chat_id, "Il raggio non può essere uguale a zero!");
        echo "Il raggio è uguale a zero!";
      }
    }
    else
    {
	send_message($chat_id, "Non ho capito!\nUso del comando: /raggio <distanza_in_metri>");
    }
  } // chiudo raggio
} // isset di text
else
{
  send_message($chat_id, "Mandami la tua posizione per conoscere i parcheggi disponibili nei dintorni.\nUtilizza \help per ulteriori informazioni.");
}

return 0;
