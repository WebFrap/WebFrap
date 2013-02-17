<h2>Übersicht Features</h2>

<p>
Eine Liste der relevanten Features der Web Frame Applikation
</p>

<h3>Architektur</h3>
<ul class="docTree" >

  <li>
    <h4>MVC</h4>
    <ul>
      <li>Strikte Model / View / Controller Architektur</li>
      <li>Dependency Inheritance Architektur</li>
      <li>Alle </li>
    </ul>
  </li>
  
  <li>
    <h4>Rollenbasierte Benutzerverwaltung</h4>
    <ul>
      <li>Systembenutzer</li>
      <li>Gruppen</li>
      <li>Profile</li>
      
      <li>
        <span>Trennung zwischen Authentifikation und Verifikation</span>
        <ul>
          <li>
            <span>Authentifikats Adapter</span>
            <ul>
              <li>Http Auth</li>
              <li>Http Digesth</li>
              <li>Http Get</li>
              <li>Http Post</li>
              <li>Sll Cert</li>
              <li>... einfach erweiterbar</li>
            </ul>
          </li>
          <li>
            <span>Verifikations Adapter</span>
            <ul>
              <li>Htaccess</li>
              <li>Ldap</li>
              <li>PAM</li>
              <li>Sql</li>
              <li>... einfach erweiterbar</li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
  
  <li>
    <h4>Acl</h4>
    <ul>
      <li>2 Level Cache</li>
    </ul>
  </li>

  <li>
    <h4>Datenbank</h4>
    <ul>
      <li>
        <span>Multiple DBMS Support</span>
        <ul>
          <li>PostgreSQL</li>
          <li>MySQL</li>
          <li>... einfach erweiterbar durch Adapter Architektur</li>
        </ul>
      </li>
      <li>Master/Slave Replikation per Konfiguration</li>
      <li>Einfaches ORM optimiert auf Single CRUD Operationen</li>
      <li>Criteria für einfache Datenbankunabhänge Abfragen</li>
      <li>DBMS spezifische Query Klassen für komplexe Abfragen</li>
      <li>Cache direkt in die Datenbank Adapter integrierbar</li>
    </ul>
  </li>

  <li>
    <h4>Cache</h4>
    <ul>
      <li>2 Level Cache</li>
      <li>Adapter Architektur</li>
    </ul>
  </li>
  
  <li>
    <h4>Request / Response Adapter</h4>
    <ul>
      <li>2 Level Cache</li>
      <li>Adapter Architektur</li>
    </ul>
  </li>
  
  <li>
    <h4>Logging</h4>
    <ul>
      <li>Ajaxconsole</li>
      <li>Cli</li>
      <li>Collector</li>
      <li>Console</li>
      <li>Database</li>
      <li>File</li>
      <li>Firephp</li>
      <li>Mail</li>
      <li>Pool</li>
      <li>Session</li>
      <li>Syslog</li>
    </ul>
  </li>
  
</ul>



