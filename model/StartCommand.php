<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.24
 */

require_once ("TelegramChainElement.class.php");

class StartCommand extends TelegramChainElement
{
    protected function onMessage($chatId, $userId, $value, $next)
    {
        if(isset($value->message->text))
        {
            var_dump(strpos($value->message->text, "/start"));
            if(strpos($value->message->text, "/start") === 0)
            {
                send_message($chatId, "Benvenuto!");
                return;
            }
        }
        $this->handleNext($value);
    }
}