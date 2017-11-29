<?php
/**
 * Created by PhpStorm.
 * User: elia
 * Date: 27/10/17
 * Time: 18.24
 */

require_once ("TelegramChainElement.class.php");

/**
 * Classe che implementa il comportamento del comando /start
 * che viene inviato automaticamente alla connessione con il Bot
 */
class HelpCommand extends TelegramChainElement
{

    const SOS = "\xF0\x9F\x86\x98";
    const TEACHER = "\xF0\x9F\x99\x8B";
    const TROUBLE = "\xF0\x9F\x98\xB1";
    const CAR = "\xF0\x9F\x9A\x97";

    const HELP_MESSAGE = "Ti serve aiuto?". HelpCommand::TROUBLE. "\nNon Preoccuparti ora ti spiego i comandi che puoi utilizzare:".HelpCommand::TEACHER."\n - /raggio <distanza_in_metri> -> Questo comando ti permette di impostare il raggio d'azione, entro il quale andrò a ricercare i parcheggi.".HelpCommand::CAR."(Assicurati di inviarmi un numero e non una parola). \n - /help -> Mi permette di aiutarti".HelpCommand::SOS;

    
    protected function onMessage($chatId, $userId, $value, $next)
    {
        if(isset($value->message->text))
        {
            if(strpos($value->message->text, "/help") === 0)
            {
                send_message($chatId, HelpCommand::HELP_MESSAGE);
                return;
            }
        }
        $this->handleNext($value);
    }
}