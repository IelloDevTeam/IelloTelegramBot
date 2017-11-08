<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.24
 */

require_once ("TelegramChainElement.class.php");

/**
 * Classe che implementa il comportamento del comando /start
 * che viene inviato automaticamente alla connessione con il Bot
 */
class StartCommand extends TelegramChainElement
{
    protected function onMessage($chatId, $userId, $value, $next)
    {
        if(isset($value->message->text))
        {
            if(strpos($value->message->text, "/start") === 0)
            {
                send_message($chatId, "Benvenuto!");
                return;
            }
        }
        $this->handleNext($value);
    }
}