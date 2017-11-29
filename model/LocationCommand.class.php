<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.44
 */

require_once ("TelegramChainElement.class.php");

class LocationCommand extends TelegramChainElement
{
    protected function onMessage($chatId, $userId, $value, $next)
    {
        if(isset($value->message->location) === True)
        {
            /* Recupero Latitudine e Longitudine */
            $lat = $value->message->location->latitude;
            $lon = $value->message->location->longitude;

            /* Recupero il raggio se salvato dal database per quell'utente */
            $db_raggio = db_row_query("SELECT raggio FROM Users WHERE user_id = $userId");

            /* Richiesta API Iello */
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
                    send_message($chatId, "Ecco i parcheggi nelle tue vicinanze");
                    foreach ($parking->message->parking as $index => $value) {
                        send_location($chatId, $value->latitude, $value->longitude);
                    }
                    return;
                }
                else
                {
                    send_message($chatId, "Non ho trovato nessun parcheggio nelle tue vicinanze");
                    return;
                }
            }
        }
        $this->handleNext($next);
    }
}