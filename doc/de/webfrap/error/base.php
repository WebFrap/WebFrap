<h1>Fehlerbehandlung in WebFrap</h1>

<p>Es gibt 4 Haupttypen von Fehlern bzw. "unerwünschte" Abläufe die auftreten können, erkannt und behandelt werden müssen.</p>

<ul>
	<li>Benutzer / Bedienfehler</li>
	<li>Programmierfehlern</li>
	<li>Konfigurationsfehler, oder der Ausfall von Services auf welche eine Applikation zugreifen möchte</li>
	<li>Mutmassliche Angriffe gegen das System</li>
</ul>

<h2>Bedienfehler</h2>

Definition: der Benutzer hat bei der Bedienung einen Fehler gemacht:

- Invalides Format bei einem Input
- Pflichtfelder vergessen
- Zu große oder zu kleine Werte welche durch Constraints abgefangen werden
- Sonstige Bedienfehler die eindeutig auf eine Fehbenutzung zurückzuführen sind.

Bedienfehler müssen im Controller bzw, dem Teil des Codes welcher die Controllerfunktionalität
übernimmt, erkannt und behandelt werden. 

Warum?
Der Controller und nur der Controller setzt den Context / Status in welchem alle anderen Komponenten
ablaufen. 
Er behandelt alle Eingaben des Benutzers. Auch ist der Controller der Platz durch welchen der
Funktionsumfang definiert wird. Somit kann auch nur dort eine wirklich präzise Fehlermeldung
erstellt werden. 