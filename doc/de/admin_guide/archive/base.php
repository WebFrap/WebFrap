<h1>Archivierung der Daten</h1>

<p>
  In der WebFrap Platform gibt es 3 Arten der Archivierung.
</p>

<h2>Operative Archivierung</h2>

<p>
  Bei der operative Archivierung werden die Daten zu einem den Daten angemessenen Stichtag
  in ein 2tes paralles Schema innerhalb der Datenbank kopiert.<br />
  Dadurch werden sie zwar aus dem Arbeitsdatenbestand entfernt, können jedoch bei Bedarf
  per VIEW + UNION über die Schemarenzen hinweg direkt mit dem Livedatenbestand
  in Relation gesetzt werden.
</p>

<img src="./images/buiz_guidance/archive/op_archive.png" alt="Operatives Archiv" />

<h3>Personenbezogene Daten im operativen Archiv</h3>

<p>
Sobald die Daten archiviert werden ist zu prüfen welche der Personenbezogenen 
Daten noch relevant sind, und ob diese gelöscht oder Annonymisiert werden können.
</p>

<h2>Ausgelagerte Archivierung</h2>

<p>
  Für die ausgelagerte Archivierung wird eine 2tes komplett vom operativen System
  getrenntes Archivsystem aufgesetzt.
  Dieses System ist primär für Statistiken über historische Daten vorgesehen. 
</p>

<img src="./images/buiz_guidance/archive/extern_archive.png" alt="Externes Archiv" />

<p>
Zu beachten ist, dass der Zugriff auf das Archivsystem nur ausgewählten Personen
zu gestatten ist. Für die täglichen Arbeiten ist das Livesystem mit dem operativen Archiv Schema vorgesehen.
</p>

<h3>Personenbezogene Daten im Ausgelagerten Archiv</h3>

<p>
Bei der Mehrzahl der Awendungsfälle sollte es nicht nötig sein personenbezogene Daten mit
in das ausgelagerte Archivsystem zu übernehmen. Personenbezogene Daten sind daher so weit
wie möglich zu löschen, oder bei bedarf zu anonymisieren, bevor Daten in das ausgelagerte Archiv
importiert werden.
</p>

<h2>Dauerhafte Archivierung</h2>

<p>
  Für die Dauerhafte Archivierung werden die Daten in komprimierte Dateien gespeichert
  und auf einem Datenträger der die nötige Speicherfrist problemfrei überstehen kann
  sicher vor unbefugten Zugriffen abgelegt.
</p>
