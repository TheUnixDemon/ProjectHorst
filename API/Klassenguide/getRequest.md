# getRequest Klassenguide

Die GET-Request wird verwendet, um sich Daten als JSON auszugeben.
Innerhalb dieser Klasse befinden sich die Methoden `getUser`, `getRounds` & `getRank`.

## User-Daten erhalten

Über die Methode `getUser` können User-Daten über den entsprechenden Username angefragt werden.
Um diese Methode aufzurufen muss also die Methode und der entsprechende Username mit übergeben.

Diese Werte werden über die Variable `method` und `username` festgelegt.

Hier ein Beispiel einer solchen Request:
```https
http://localhost/API/main.php?method=getUser&username=TheUnixDaemon
```

So wäre z.B eine Ausgabe:
```json
[
{"user_id":1,"user_picture":null,"password":null,"user_email":"TheUnixDaemon@gmail.com","username":"TheUnixDaemon","superRights":null,"rights":null,"full_score":0.667}
]
```

## Daten zu den letzten Runden erhalten

Über die Methode `getRounds` werden zu einem bestimmten User die letzten zwanzig Runden, als JSON, ausgegeben-
Hier ist die Übergabe der Variablen die gleiche wie bei der Methode `getUser`.

Hier ein Beispiel einer solchen Request:
```https
http://localhost/API/main.php?method=getRounds&username=TheUnixDaemon
```

So wäre z.B eine Ausgbe:
```json
[
{"score":1,"owner":"TheUnixDaemon","guest":"luca","role":0,"round_create_date":"2023-03-06"},
{"score":1,"owner":"TheUnixDaemon","guest":"luca","role":1,"round_create_date":"2023-03-05"},
{"score":0,"owner":"TheUnixDaemon","guest":"luca","role":1,"round_create_date":"2023-03-02"}
]
```

## Rang des Users erhalten

Über die Methode `getRank` wird anhand des jetzigen `full_score` der Rang in Echtzeit ermittelt und für den entsprechenden User ausgegeben.
Der Aufruf der Methode und die zu übergebenen Variablen verläuft wie bei der Methode `getUser`.

Hier ein Beispiel einer solchen Request:
```https
http://localhost/API/main.php?method=getRank&username=TheUnixDaemon
```

So wäre z.B eine Ausgbe:
```json
[
{"position":1,"user_id":1,"username":"TheUnixDaemon","full_score":0.667}
]
```

Die Variable `position: 1` gibt den Rang wieder.
