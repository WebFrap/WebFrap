<h1>Zugriffslevel</h1>

<p>Welche Rechte genau gewährt werden hängt an den Zugriffsleveln (Nicht zu verwechseln mit den User-Leveln)</p>

<ul class="doc_tree" >
  <li><span>DENIED: 0</span>, Kein Zugriff</li>
  <li><span>LISTING: 1</span>, Darf eine Liste der Datensätze sehen, kann jedoch nicht die Datensätzen zum lesen öffnen</li>
  <li><span>ACCESS: 2</span>, Lesender Zugriff auf den Datensatz ist gestattet, es dürfen jedoch keine Änderungen vorgenommen werden</li>
  <li><span>ASSIGN: 4</span>, Der Benutzer darf diesen Datensatz / Datensätze aus dieser Datenquelle verlinken</li>
  <li><span>INSERT: 8</span>, Der Benutzer darf neue Datensätze erstellen, wenn auf einem Datensatz innerhalb eines Baumes, dürfen neue Unterknoten erstellt werden</li>
  <li><span>UPDATE: 16</span>, Der Benutzer darf bestehend Datensätze verändern</li>
  <li><span>DELETE: 32</span>, Die Lizenz zum töten, Pardon löschen</li>
  <li><span>PUBLISH: 64</span>, Es dürfen Datensätze freigeschaltet/publiziert werden. Findet in allen Szenarien Anwendung in denen Daten vor dem "Einsatz" geprüft werden müssen</li>
  <li><span>MAINTENANCE: 128</span>, Zugriff auf die Wartungsfunktionalität, Logs, Fehlermeldungen, Import/Export Funktionalität und sonstige vergleichbare Elemente</li>
  <li><span>ADMIN: 256</span>, Vergabe von Berechtigungen and andere Benutzer</li>
</ul>
