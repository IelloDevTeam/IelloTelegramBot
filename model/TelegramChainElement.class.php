<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.29
 */

require_once ("ChainElement.class.php");
/**
 * Classe che rappresenta un elmento di una catena, in particolare
 * un elemento Telegram, poichè in ogni messaggio telegram sono presenti
 * l'id della chat e l'id dell'utente è utile passare ad ogni altro elemento
 * della catena Telegram quest'ultimi per agevolare l'invio di risposte.
 */
abstract class TelegramChainElement extends ChainElement
{
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