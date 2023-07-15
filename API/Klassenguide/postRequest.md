# getRequest Klassenguide

Die POST-Request wird verwendet, um Daten in die Datenbank mittels `INSERT` einzuspeisen oder Daten in der Datenbank mittels `UPDATE` zu updaten. 
Innerhalb dieser Klasse befinden sich die Methoden `postScore` & `postFullScore`.

Die nötigen Variablen sind:
- `postMethod`: als STRING zu übergeben
<br>gibt die aufzurufende Methode`[postScore | postFullScore]` an

- `user_id`   : als INT zu übergeben
<br>wird über die `getUser` Methode erhalten & ist gleichzuätzen mit dem bewerteten Spieler

- `guest_id`  : als INT zu übergeben
<br>wird über die `getUser` Methode erhalten & ist gleichzusätzen mit dem Mitspieler

- `role`      : als BOOLEAN zu übergeben
<br>steht für die Runde die von `user_id` gespielt worden ist

- `round_duration`  : als TIME zu übergeben
<br>representiert die Dauer, wie lange gespielt wurde

- `score`     : als BOOLEAN zu übergeben
<br>representiert, ob `user_id` gewonnen`[1]` hat oder verloren`[0]` hat

## Runden und ihre Ergebnisse uploaden

Diese Methode sollte nach jeder beendeten Runde aufgerufen werden und sollte vermieden werden, falls die Runde z.B Vorzeitg abgebrochen wurde.
Sie übergibt die Runden-Informationen und weißt sie den entsprechenden User zu.

!!!WICHTIG!!!
Bei dem Upload einer Runde gibt es eine `user_id` und eine `guest_id`. Der Score gilt nur für `user_id`, weshalb müssen zwei Einträge pro Spieler gemacht werden.

Hier müssen alle oben genannten Variablen gesetzt sein und die Variable `postMethod` muss auf `postScore` stehen.
Dann müsste der Aufruf der Methode funktieren.

## Den Score setzten

Hierbei wird Anhand der letzten 15 bis 20 Runden der Score ermittelt, indem es aus den Scores den WIN-/LOSE-Durchschnitt berechnet.

Diese Methode wird aufgerufen, indem die Variable `postMethod` auf `postFullScore` gesetzt wurde und auch die Variable `user_id` gesetzt und übergeben wurde.

Diese Methode wird automtisch am Ende der Methode `postScore` aufgerufen und muss so in der Regel nicht selbst ausgeführt werden.
