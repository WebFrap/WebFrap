<h1>Zugriffskontrolle</h1>

<p>
Die Zugriffskontrolle auf die Daten muss systemweit einheitlich implementiert sein.
Im Idealfall werden die dazu nötigen Informationen aus einer zentralen Datenquelle (z.B. ein LDAP) bezogen.
Bei mehr als einer Quelle besteht die Gefahr für inkonsistente Zugriffsberechtigungen.
</p>

<p>
Die <?php kw('platform.name') ?> implementiert mehrere abgestufte Zugriffscontrolmechanismen:
</p>

<ul class="doc_tree" >
  <li>
    <span>Mandatory Access Control</span>: basierend auf dem Benutzer zugewiesenen User-Leveln und Security Area zugewiesenen 
    Level Anforderungen.
    Diese Art der Berechnung wird verwendet, um einfache Berechtigungen unkritische Datenquellen (Tabellen, Views, Masken) zu geben. 
    Konkrete Beispiele für den Einsatz wäre z.B die Verwaltung der Rechte für Metainformationen wie: "Status", "Type", "Category".
  </li>
  <li>
    <span>Access Control Lists</span>: kommen dann zu Einsatz wenn durch eine reine Levelbasierte Zugriffskontrolle die nötige 
    Granularität bei den Zugriffen nicht mehr erreicht werden kann, oder wenn Benutzer explizit 
    in eine Beziehung mit einer Datenquelle oder einem Datensatz gestellt werden sollen. 
    ACLs sind rechenzeitintensiver als die einfache MAC, ermöglichen jedoch für jeden User separate
    Zugriffsberechtigungen auf einzelne Datensätze.
  </li>
</ul>

<p>Im folgenden werden die Elemente und das Konzept des Zugriffcontrolsystems der <?php kw('platform.name') ?> beschrieben.</p>

