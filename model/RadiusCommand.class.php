<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.34
 */

require_once ("TelegramChainElement.class.php");

/**
 * Classe che rappresenta l'elemento della catena Telegram
 * che implementa il comportamento per il comando /radius.
 */
class RadiusCommand extends TelegramChainElement
{
    /* costanti per le risposte */
    const ERROR = "\xF0\x9F\x9A\xAB";
    const MISUNDERSTANDING = "\xF0\x9F\x98\xB3";
    const READY = "\xE2\x9C\x94";
    const CAR = "\xF0\x9F\x9A\x97";

    /** Risposte **/
    const RADIUS_SETTED = RadiusCommand::READY . " Perfetto, quando vorrai richercherò parcheggi ad una distanza massima di: ";
    const RADIUS_ZERO = "Attento! " . RadiusCommand::ERROR . " Il raggio non può essere zero!";
    const RADIUS_INVALID = RadiusCommand::MISUNDERSTANDING . " Non ho capito!\nUso del comando: /raggio <distanza_in_metri>";


    protected function onMessage($chatId, $userId, $value, $next)
    {
        if(isset($value->message->text))
        {
            /* Verifico se il comando è /raggio */
            if(strpos($value->message->text, "/raggio") === 0) {

                /* Estrazione del raggio */
                $raggio = substr($value->message->text, 7);

                /* Validazione Raggio */
                if ($raggio && !empty($raggio) && is_numeric($raggio)) {
                    if ($raggio > 0) {
                        db_perform_action("REPLACE INTO Users(user_id, raggio) VALUES($userId, $raggio)");
                        send_message($chatId, RadiusCommand::RADIUS_SETTED . $raggio . "m " . RadiusCommand::CAR);
                        return;
                    } else {
                        send_message($chatId, RadiusCommand::RADIUS_ZERO);
                        return;
                    }
                } else {
                    send_message($chatId, RadiusCommand::RADIUS_INVALID);
                    return;
                }
            }
        }
        $this->handleNext($value);
    }
}
