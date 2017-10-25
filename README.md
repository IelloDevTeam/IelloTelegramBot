# Iello Bot (Read me in lavorazione) #

All'interno del progetto Iello, è stato implementato il seguente Bot per accedere ai dati anche attraverso la piattaforma di messagistica Telegram. 

## Indice contenuti

Contenuti de README: 

1. Comandi disponibili;
2. integrazione con Iello API;
3. licenza;
4. contatti & crediti.


## Comandi disponibili##

All'interno del Bot è possibile inviare la propria posizione e poter visualizzare i parcheggi nelle vicinanze con i seguenti comandi:

1. utilizzando la funzionalità di Telegram di invio della posizione, il Bot restituisce le posizioni vicine in un raggio di default di 500m;
2. /raggio {numero in metri}: imposta il raggio di ricerca a quello specificato dall'utente.

Inoltre, per la memorizzazione delle preferenze degli utenti sul raggio di ricerca, è stato implementato un data base formato da una singola tabella con due
campi: Utente e raggio. 

## Integrazione con Iello-Api ##

Il Bot è stato implementato utilizzando [Iello API](https://bitbucket.org/piattaformeteam/iello-api "Iello API Repo"). 
In particolare si usa il metodo /parking GET per restituire i parcheggi presenti nel database.

## Licenza ##

Copyright (C) 2017 TeamPiattaforme
Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except 
in compliance with the License. You may obtain a copy of the License at
http://www.apache.org/licenses/LICENSE-2.0
Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

## Contatti & Credits ##

App realizzata come parte di un progetto di esame (PDGT) 
da Riccardo Maldini, Andrea Petreti, Elia Trufelli e Alessia Ventani. Se vuoi contattarci, scrivi un e-mail a riccardo.maldini@gmail.com