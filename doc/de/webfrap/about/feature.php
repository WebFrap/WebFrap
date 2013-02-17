<h2>Liste der Feature</h2>


<h3>Architektur</h3>
<p></p>

<ul>
  <li>Strikte MVC Architektur</li>
  <li>
    Wichtiger Resourcen sind durch Adapter einfach erweiterbar. Welche Adapter zum Einsatz kommen, kann ohne weitere Änderungen
    direkt konfiguriert werden.
  </li>
  <li>Dependency Injection</li>
  <li>On Demand Resource Handling, Resourcen werden erst dann belegt / erstellt wenn sie wirklich benötigt werden.</li>
</ul>

<h3>Domain Feature</h3>
<p></p>

<ul>
  <li>RIA Interface</li>
  <li>Logging und Protokolle</li>
  <li>Umfangreiche Statistikfunktionen</li>
  
  <li>Unterstützung relevanter Export Formate
    <ul>
      <li>XML</li>
      <li>JSON</li>
      <li>CSV</li>
      <li>Excel</li>
    </ul>
  </li>
</ul>


<h3>Technische Feature</h3>
<p></p>

<ul>
  <li>PHP Basiertes Templatesystem</li>

  <li>
    <h4>Multi DBMS Datenbanklayer</h4>
    <ul>
      <li>ORM Support</li>
      <li>Master Slave Support implementiert, komplett konfigurierbar</li>
      <li>SQL Query Objekte</li>

      <li>
  <h4>Bereits vorhandene Adapter</h4>
  <ul>
    <li>Postgresql (pgsql)</li>
    <li>Postgresql (PDO)</li>
    <li>MySql (mysql)</li>
    <li>MySql (mysqli)</li>
    <li>MySql (PDO)</li>
  </ul>
      </li>
    </ul>
  </li>

  <li>
    <h4>Anbindung an Spezialisierte Datenbanken und Searchengines</h4>
    <ul>
      <li>Lucene</li>
      <li>Solar</li>
      <li>Neo4J</li>
    </ul>
  </li>

  <li>
    <h4>Advanced Login / Authentification</h4>
    <p>Es existiert eine strikte Trennung zwischen Authentification und Verification</p>

    <h4>Authentification Adapter</h4>
    <ul>
      <li>HttpAuth</li>
      <li>SSO</li>
      <li>HttpPost</li>
    </ul>

    <h4>Verification Adapter</h4>
    <ul>
      <li>Sql (Prüfung gegen die Datenbank)</li>
      <li>LDAP (Prüfung gegen einen LDAP)</li>
    </ul>

  </li>

  <li>
    <h4>Cachingsystem</h4>
    <ul>
      <li>Filesystem Adapter</li>
      <li>PHPSession Adapter</li>
      <li>Memcache Adapter</li>
      <li>SQLite Adapter</li>
      <li>APC Adapter</li>
      <li>XCache Adapter</li>
    </ul>
  </li>

</ul>