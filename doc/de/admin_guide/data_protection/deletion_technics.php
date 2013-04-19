<h1>Löscharten</h1>

<p>Die WebFrap Platform unterstützt verschiedene Formen des Löschens von Daten.</p>

<h2>Deletion Flag</h2>

<p>
Bei dieser Technik werden Einträge in der Datenbank als gelöscht markiert,
werden beim zugriff als nicht existent vermeldet, bleiben jedoch physisch
weiterhin bestehen.
Diese Technik wir bei wichtige Daten für das "operative" löschen angewendet, da
sie die Option offen lässt den Löschvorgang im Fehlerfall rückgängig zu machen.
</p>

<p>
Beim Einsatz von Deletion Flags, muss über Regeln sicher gestellt werden, dass
persönlichen Daten spätestens zum Ablauf der dem Anwendungsfall angemessenen Frist
auch physisch aus der Datenbank gelöscht werden. Dies lässt sich einfach durch 
Regeln und den internen Taskplaner implementieren.
</p>

<p>
Gerade bei Personenbezogenen Daten ist diese Methode vorzuziehen, da das eigentliche
Löschen der Daten oft nicht nur an den Willen der abgebildeten Person, sondern auch an gesetzlich
vorgegebene Fristen zur Aufbewahrung gekoppelt ist.
</p>

<h2>Direct Delete</h2>

<p>
Beim direkten löschen werden die Datensätzen per SQL bei DBMS, oder rm auf dem Dateisystem
gelöscht. Dabei werden auch potentiell vorhandene gecachte Version der Daten entfernt.
Weiter werden alle abhängigen referenzierende Datensätze cascadierend gelöscht.
Für jeden einzelnen Datensatz wird dabei ein Löschevent in der Applikation getriggert.
</p>

<p>Dateien, oder Datensätze die auf Basis des oder der gelöschten Datensätze entstanden sind
bleiben bei dem Direct Delete Verfahren bestehen.
</p>

<h2>Purge</h2>

<p>
Purge ist die radikalste form des Löschens. Der Datensatz wird aus dem Datenverwaltenden System
kaskadierend gelöscht (SQL,rm, sonstige delete requests). Weiter werden
soweit sinnvoll möglich alle Sonstigen Daten wie Dateien, Statistiken oder sonstige Dokumente
gelöscht oder neu erzeugt, so dass der gelöschte Datensatz komplett getilgt wird.
</p>

