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
    const WHEEL_CHAIR = "\xE2\x99\xBF";
    const PARK = "\xF0\x9F\x85\xBF";
    const CAR = "\xF0\x9F\x9A\x97";
    const SAD = "\xF0\x9F\x98\x9E";
    const CRY = "\xF0\x9F\x98\xA2";

    const FOUND_PARK_MESSAGE = "Ecco i parcheggi nelle tua vicinanze " . LocationCommand::CAR . LocationCommand::PARK . LocationCommand::WHEEL_CHAIR;
    const NOT_FOUND_PARK_MESSAGE = "Non ho trovato nessun parcheggio nelle tue vicinanze " . LocationCommand::SAD;
    const ERROR_API = "Mi dispiace credo di avere un piccolo problema a contattare il mio database. " . LocationCommand::SAD . LocationCommand::CRY; 

    protected function onMessage($chatId, $userId, $value, $next)
    {

        if(isset($value->message->location))
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
                    send_message($chatId, LocationCommand::FOUND_PARK_MESSAGE);
                    foreach ($parking->message->parking as $index => $value) {
                        send_location($chatId, $value->latitude, $value->longitude);
                    }
                    return;
                }
                else
                {
                    send_message($chatId, LocationCommand::NOT_FOUND_PARK_MESSAGE);
                    return;
                }
            }
            else
            {
                send_message($chatId, LocationCommand::ERROR_API);
                return;
            }
        }
        $this->handleNext($value);
    }
}