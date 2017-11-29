<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 27/10/17
 * Time: 18.44
 */

require_once ("TelegramChainElement.class.php");

/**
 * Questa elemento di catena invia un messaggio di errore all'utente
 * usata come ultima catena per indicare che nessun comando è stato riconosciuto.
 */
class UnknownCommand extends TelegramChainElement
{
	const MISUNDERSTANDING = "\xF0\x9F\x98\xB3";
	const SOS = "\xF0\x9F\x86\x98";

	const MESSAGE = "Non capisco.".UnknownCommand::MISUNDERSTANDING." Digita /help per ottenere informazioni su come usarmi.".UnknownCommand::SOS;

    protected function onMessage($chatId, $userId, $value, $next)
    {
    	send_message($chatId, UnknownCommand::MESSAGE);
    	return;
    }
}
