<h1>Zugriffskontrolle</h1>

<p>
Der Zugriff auf die Daten ist so zu implementiert, dass nur authorisierte
Personen auf eine ihren Aufgaben angemessene Menge der Daten zugreifen können.
Dies ist sowohl für Daten innerhalb, als auch Auserhalb des Systems sicher zu stellen.
</p>

<p>Zur technischen Umsetzung dieser Forderung sind folgende Maßnahmen nötig:</p>

<ul class="doc_tree" >
  <li>
    Zugriff auf die Daten nur nach erfolgreicher Autentifikation und Verifikation des Benutzers. Dies gilt besonders
    bei Anfragen von Personen an Anwender des Systems mit der Bitte um Daten, die sie sich offensichtlich
    nicht selbst besorgen konnten.
  </li>
  <li>Transfer der Daten nur über gesicherte (verschlüsselte) Verbindungen oder Datenträger</li>
  <li>Vermeidung unsicherer temporärer Speicher, z.B. Ablage im Browsercache / Proxies / Varnish</li>
  <li>Die Daten sind so zu speichern, dass sie nicht einfach durch pysikalische Angriffe ausgelesen werden können. (Rechenzentrum
  mit angemessener Schutzklasse), dies gilt sowohl für Operative Systeme als auch Backups</li>
  <li>Das Risiko für Datenverluste sind durch regelmäßige Backups zu minimieren</li>
  <li>Die Integrität kritischer Daten, sowie der Backups ist durch Checksummen sicher zu stellen</li>
</ul>

