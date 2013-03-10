<h1>Datenmodell im Kontext des Datenschutzes</h1>

<p>
Das WBF 42 Standard Datenmodell ist so designed, dass es eine große Menge
an Daten speichern und Verwalten kann. Die Menge der speicherbaren Daten
übersteigt praktisch für jeden Kontext die Menge der sinnvoll speicherbaren Daten.
</p>

<p>
Ziel des Standard Datenmodells ist es eine große Menge möglicher Anwendungsfälle
zu ermöglichen. Um das mit den Anforderungen der Datenschutzbestimmungen in einklang
zu bringen, ist es nötig, dass Usecase spezifische Masken zu erstellt werden, welche
nur die Ver- und Bearbeitung dem Anwendungsfall angemessener Daten zulassen.
</p>

<p>
Technisch ist dies durch das Erstellen von speziellen Views oder Webservices realisierbar.
Das ist vor allem dann wichtig, wenn Module von Dritten direkt in die Applikation geladen werden
oder über Webservices auf die Daten zugreifen können.
</p>

<p>
Wenn absehbar ist, dass bestimmte Informationen nie in dem System gespeichert werden
sind die betroffenen Entities und/oder Attribute über abgeleitete Modellknoten 
zu deaktivieren, und damit aus Programmcode zu entfernen.
</p>

