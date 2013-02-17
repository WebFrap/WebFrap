
<h1>Struktur eines Application Modules</h1>

<label>Ordner Struktur eine App/Mod Projektes</label>


<ul class="doc_tree cells" style="width:700px;" >
  <li><span>conf</span> <div class="cell" >Enthält Modulspezifische Konfigurationsdateien.</div>
    <ul>
      <li><span>conf/menu</span> <div class="cell" >Enthält Modulspezifische Menüerweiterungen für den WebFrap Explorer.</div></li>  
    </ul>
  </li>
  <li><span>data</span> 
    <div class="cell" >
    Enthält Metadaten für den Datenbank sync. Darüber hinaus können Basiswerte für Tabellen, Rollen, Benutzer etc. hinterlegt werden.
    Bei den Metadaten ist es später nichtmehr wichtig in welchem Projekt sie liegen, dass der Sync alle eingebundenen Projekte durchsucht.
    </div>
  </li>
  <li><span>i18n</span>
    <div class="cell" >
    In i18n werden wie der Name es bereits vermuten lässt die I18N (Internationalisierungsdateien) aufbewart.
    </div>
    <ul>
      <li><span>i18n/de</span></li>
      <li><span>i18n/en</span></li>
      <li><span>i18n/fr</span></li>
      <li><span>i18n/...</span></li>
    </ul>
  </li>
  <li><span>module</span>
    <div class="cell" >
    Innerhalb der Module wird der Domain-Code aufbewart.
    </div>
  </li>
  <li><span>templates</span>
    <div class="cell" >
    Innerhalb von Templates werden alle Templates aufbewahrt
    </div>
    <ul>
      <li><span>templates/default/content</span>
        <div class="cell" >
          Content Templates enthalten den Hauptcontent Teil der Seite. z.B eine Liste mit Suchformular.  Das Layout befindet sich in den Indextemplates.
          Bei Maintab Ajax Requests wird z.B. dieses Template als neuer Tab verwendet.
        </div>
      </li>
      <li><span>templates/default/index</span>
        <div class="cell" >
          Die Indextemplates enthalten die Layouttemplates. In ihnen wird definiert wo sich später Menüs, das Hauptcontent, Header und Footer etc. befinden.
          Indextemplates werden bei Ajaxrequests nicht ausgetauscht. Sie geben den Rahmen für die aktuelle Logik vor.
          Über das Indextemplate wird, z.B. auch zwischen eier Backendseite und einer Frontend Seite unterschieden.
        </div>
      </li>
      <li><span>templates/default/messages</span>
        <div class="cell" >
          Templates für Mails
        </div>
      </li>
    </ul>
  </li>
  <li><span>src</span>
    <div class="cell" >
      Src enthält technische Logik, wie z.B. LibDbConnection. Das Namensschema ist im Gegensatz zur Domainlogik vertauscht.
      Die Art der Klasse steht am Anfang, da diese Gruppierung bei technischer Logik sinnvoller ist.
    </div>
  </li>
  <li><span>sandbox</span>
    <div class="cell" >
      Innerhalb der Sandbox existiert nocheinmal die gleiche Struktur.
      Die Sandbox ist für generierten Code. Innerhalb der Sandbox, darf nicht 
      per Hand geschrieben werden, da diese Änderungen beim generieren gnadenlos überschrieben werden.
    </div>
    <ul>
      <li><span>sandbox/conf</span>
        <ul>
          <li><span>sandbox/conf/menu</span></li>  
        </ul>
      </li>
      <li><span>sandbox/i18n</span>
        <ul>
          <li><span>sandbox/i18n/de</span></li>
          <li><span>sandbox/i18n/en</span></li>
          <li><span>sandbox/i18n/fr</span></li>
          <li><span>sandbox/i18n/...</span></li>
        </ul>
      </li>
      <li><span>sandbox/module</span></li>
      <li><span>sandbox/templates</span></li>
      <li><span>sandbox/src</span></li>  
    </ul>
  </li>
</ul>