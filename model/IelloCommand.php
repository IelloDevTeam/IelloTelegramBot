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
class IelloCommand extends TelegramChainElement
{
    const RIGHT_HAND = "\xF0\x9F\x91\x89";
    const CAT = "\xF0\x9F\x90\xB1";
    const FACE = "\xF0\x9F\x98\x8F";

    const IELLO_MESSAGE = "Loro sono i miei creatori ".IelloCommand::RIGHT_HAND."Riccardo Maldini - Andrea Petreti - Alessia Ventani - Elia Trufelli.\nSe vuoi maggiori informazioni sul progetto Iello visita la nostra pagina GitHub ".IelloCommand::CAT." https://github.com/IelloDevTeam.\nSai io ho un fratello maggiore che fa al caso tuo, se vuoi conoscerlo ti lascio questo link ".IelloCommand::FACE." https://play.google.com/store/apps/details?id=com.projectiello.teampiattaforme.iello";

    protected function onMessage($chatId, $userId, $value, $next)
        if(isset($value->message->text))
        {
            if(strpos($value->message->text, "/iello") === 0)
            {
                send_message($chatId, IelloCommand::IELLO_MESSAGE);
                return;
            }
        }
        $this->handleNext($value);
    }
}