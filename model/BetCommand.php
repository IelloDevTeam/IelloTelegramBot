<?php
/**
 * Created by PhpStorm.
 * User: elia
 * Date: 27/10/17
 * Time: 18.34
 */

require_once ("TelegramChainElement.class.php");

/**
 * Classe che rappresenta l'elemento della catena Telegram
 * che implementa il comportamento per il comando /radius.
 */
class BetCommand extends TelegramChainElement
{
    const BALL = "\xE2\x9A\xBD";
    const UNDERAGE = "\xF0\x9F\x94\x9E";
    const HAND = "\xF0\x9F\x91\x90";
    const BET_MESSAGE = "Vedo che abbiamo un nuovo scommettitore!". BetCommand::UNDERAGE." clicca il link che hai appena ricevuto e vedrai che non ti pentirai".BetCommand::BALL. BetCommand::HAND."\nnhttps://play.google.com/store/apps/details?id=com.maldini.riccardo.betassist";

    protected function onMessage($chatId, $userId, $value, $next)
        if(isset($value->message->text))
        {
            if(strpos($value->message->text, "/gol") === 0)
            {
                send_message($chatId, BetCommand::BET_MESSAGE);
                return;
            }
        }
        $this->handleNext($value);
    }
}

