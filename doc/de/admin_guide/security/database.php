<h1>Datenbank</h1>

<p>
Die Datenbank, bzw. die in ihr enthaltenden Daten sind meist das eigentlich
Angriffsziel. Daher nützt es nur wenig, die Applikation bis zu Perfektion zu sichern
wenn die Datenbank von Haus aus offen wie ein Scheunentor ist.
</p>

<p>Für Zugriffe auf die Datenbank sind folgende Regeln zu beachten:</p>

<ul class="doc_tree" >
  <li>
    Zugriffe auf die Datenbank dürfen nur über verschlüsselte Verbindungen erfolgen, es sei denn
    sie läuft lokal über ein Unix loopback device. Alle Netzwerkzugriffe müssen! verschlüsselt
    passieren. Sollte das zu Performanceproblemen führen dann ist per Definition die Hardware zu langsam.
  </li>
  <li>
    WAL (Write ahead Logs) müssen aktiviert sein, so dass die Datenbank zu jedem Zeitpunkt
    auf einen bestimmten Zustand zurückversetzt werden kann.
  </li>
  <li>
    Die Datenbank hat eine saubere Rollenbasierte ACL Implementierung.
    Diese ist auch zu nutzen!<br />
    Alle Personen und System welche mit dem System kommunizieren dürfen müssen einen
    eigenen ihren Bedürfnissen und Befugnissen angepassten System Benutzer bekommen.
    Dabei ist es besonders wichtig, dass gerade die Benutzer für Applikationen 
    so eingeschränkte Rechte wie möglich haben, um den Schaden, der durch theoretisch
    mögliche SQL Injection Attacken auftreten kann zu minimieren.<br />
    Aus diesem Grund kann es Usecase bezogen sogar nötig sein, mehrere verschiedene
    Datenbank benutzer für die Komponenten einer Applikation anzulegen.
    z.B eine öffentliche Komponente wie ein CMS oder Shop-System benutzt nur einen
    Datenbankuser mit stark eingeschränkten Zugriff auf die Datenbank. <br />
    Die Admin-Komponente hingehen bekommt einen User mit Vollzugriff.
  </li>
  <li>
    Es müssen regelmäßig Backups der Datenbank erstellt werden. 
    Die Backups sind zu verschlüsseln um sie gegen Auslesen und Manipulation zu schützen. 
    Weiter ist eine Checksumme (mit einem aktuell geeigneten, noch nicht geknackten Algorithmus) des Dumps
    zu erstellen, um potententielle Manipulationen, so unwahrscheinlich sie auch sein mögen,
    zu erkennen. 
  </li>
</ul>
