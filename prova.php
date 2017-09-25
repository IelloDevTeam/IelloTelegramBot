<?php
require_once("config.php");

require_once("lib_database.php");
$url_base = "https://api.telegram.org/bot404016358:AAFY5DagRE798jch-LLZRPOTXU4IXKj_Klw/";

$offset = file_get_contents("update_id.txt");

if(@$offset)
{
	$curl_send = curl_init($url_base . "getUpdates?offset=" . $offset);
}
else
{
	$curl_send = curl_init($url_base . "getUpdates");
}

curl_setopt($curl_send, CURLOPT_RETURNTRANSFER, true);

$update = curl_exec($curl_send);
$httpCode = curl_getinfo($curl_send, CURLINFO_HTTP_CODE);
curl_close($curl_send);

if($httpCode == 200)
{
	$update = json_decode($update);

	if($update->ok === true)
	{
		if(count($update->result) > 0)
		{
			file_put_contents("update_id.txt", $update->result[count($update->result) - 1]->update_id +1);
			var_dump($update->result);
			foreach ($update->result as $index => $value) {
				$chat_id = $value->message->chat->id;
				//echo "Messaggio da: " . $value->message->from->first_name . "\t";
				if(isset($value->message->location))
				{
					$lat = $value->message->location->latitude;
					$long = $value->message->location->longitude;
					$user_id = $value->message->from->id;
					$db_raggio = db_row_query("SELECT raggio FROM Users WHERE user_id = $user_id");

					if(!$db_raggio)
					{
						$curl_api = curl_init("http://localhost:3000/parking?lat=" . $lat . "&lon=" . $long);
					}
					else {
						$raggio = $db_raggio[0];
						$curl_api = curl_init("http://localhost:3000/parking?lat=" . $lat . "&lon=" . $long . "&radius=" . $raggio);
					}

					curl_setopt($curl_api, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($curl_api);
					$httpCode = curl_getinfo($curl_api, CURLINFO_HTTP_CODE);
					curl_close($curl_api);

					if($httpCode == 200)
					{
						$parking = json_decode($result);

						var_dump($parking);
						if($parking->message->parking_count > 0)
						{
							foreach ($parking->message->parking as $index => $value) {
								$curl_send = curl_init($url_base . "sendLocation?chat_id=" . $chat_id . "&latitude=" . $value->latitudine . "&longitude=" . $value->longitudine);
								curl_setopt($curl_send, CURLOPT_RETURNTRANSFER, true);
								curl_exec($curl_send);
								curl_close($curl_send);
							}
						}
						else
						{
							$curl_send = curl_init($url_base . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode("Non ho trovato nessun parcheggio nelle tue vicinanze"));
							curl_setopt($curl_send, CURLOPT_RETURNTRANSFER, true);
							curl_exec($curl_send);
							curl_close($curl_send);
						}
					}
				}
				else if($value->message->text)
				{

					if(strpos($value->message->text,"/raggio") == 0){
						echo ('Received /raggio command!\n');
						// estraggo raggio

						$raggio = substr($value->message->text,7);

						if($raggio > 0){
							// uso funzione di libreria che permette di eseguire query senza risultato
							// insert into
							$id = $value->message->from->id;
							db_perform_action("REPLACE INTO Users(user_id, raggio) VALUES($id, $raggio)");
						}else{
							$curl_send = curl_init($url_base . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode("Il raggio non può essere uguale a zero!"));
							curl_setopt($curl_send, CURLOPT_RETURNTRANSFER, true);
							curl_exec($curl_send);
							curl_close($curl_send);
							echo "Il raggio è uguale a zero!";
						}



					}
				}
				else{

					echo "Non posizione\n";
				}

			}
		}
	}
	else
	{
		error_log("Errore");
	}
}
else error_log("Errroorrrrrr");
