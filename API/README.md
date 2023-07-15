# WebDev-API

Die API dient als Schnittstelle zwischen Spiel und Datenbank, die sich im [WebDev-Horst](https://github.com/SubStorys/WebDev-Horst/tree/main/Datenbanken) Repository befindet. 
Diese wird Klassenbasierend Entwickelt. Um SQL-Injections zu verhindern wird auf die Prepare-Funktion zurückgeriffen.
Die API richtet sich an den API-Standart. Auf den Wunsch von der Gruppe GameDev wurde nur die POST- & GET-Methode implementiert.

## Wie wird die API verwendet?

Es wird entweder über die POST- oder GET-Request auf die Methoden zugegriffen. 
Da auf die POST-Request nicht über eine URL-Request zugegriffen werden kann, ist es hier von der Aplikation abhängig.
Anders als bei der POST-Request, könnte eine GET-Rquest so aussehen:
`https://localhost:1500/main.php?method=getUser&username=TheUnixDaemon`

### Genaueres zu dem Aufruf der Methoden und den zu übergebenden Variablen:

* [UML](UML/UML_API.png)
* [GET-Request-Klassenguide](Klassenguide/getRequest.md)
* [POST-Request-Klassenguide](Klassenguide/postRequest.md)
* [API-URL](https://henschel-server.ddns.net:1550/main.php)