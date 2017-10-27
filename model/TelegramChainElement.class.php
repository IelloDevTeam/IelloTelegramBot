<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.29
 */

require_once ("ChainElement.php");

abstract class TelegramChainElement extends ChainElement
{
    /* Attributi sempre presenti in Telegram */
    /**
     * @var $value
     * @var $next ChainElement
     */
    public function handle($value, $next)
    {
        // recupero l'id chat e l'id utente
        $chat_id = $value->message->chat->id;
        $user_id = $value->message->from->id;
        $this->onMessage($chat_id, $user_id, $value, $next);
    }

    protected abstract function onMessage($chatId, $userId, $value, $next);
}