
<h1>Projekt Typen</h1>

<p>
Innerhalb der WebFrap Plattform gibt es eine Reihe spezieller Projekttypen.<br />
Auch wenn die Projektarchitektur so ausgelegt ist, dass beim deployment alle Projekte
in einen Projektordner gemerged werden können sind die Projekte bei der Entwicklung 
zu trennen.
</p>

<label>Projekt Typen</label>
<ul class="doc_tree cells" style="width:700px;" >
  <li><span>Basis / FW Projekte</span> 
    <div class="cell" >
      Basis, bzw. Frameworkprojekte sind ähnlich wie die Libprojekte rein technische Projekte.
      Sie sind jedoch wesentlich umfassender und enthalten auch UIs.
    </div>
  </li>
  <li><span>App/Module Projekt</span> 
    <div class="cell" >App/Mod Projekte enthalten die die Business Logik einer Applikation.</div>
  </li>
  <li><span>Gateway Projekt</span> 
    <div class="cell" >
      Gateway-Projekte sind die Hauptprojekte. Sie enthalten alle Konfigurationsangaben, z.B. Datenbankverbindung,
      Das zu verwendente Theme und Icon Projekt, eine liste aller App/Module und Lib welche eingebunden werden, etc. 
      Weiter enthalten sie die Session, Uploads, und sonstige Projektspezifische Dateien.
      Sie sind quasi das Projekt, nur ohne Logik und Layout.
    </div>
  </li>
  <li><span>Lib Projekt</span> 
    <div class="cell" >
    Lib Projekte sind rein technische Projekte. In ihnen werden z.B, Paymentsystem Connectore, Dokumentgeneratoren etc.
    implementiert.
    Lib Projekte sind per definition Domainunabhängig und sind so zu designen, dass sie in jedem Modul und jeder Applikation eingebunden
    werden können.
    Domainspezifische Erweiterungen sind in den für die Domain zuständigen App/Modulprojekten abzulegen.<br />
    Libs enthalten keine oder nur wenig UI Logik. Zulässig (und wenn bentigt auch sinnvoll) wären z.B Konfigurationsmasken.
    </div>
  </li>
  <li><span>Modell (42) Projekt</span> 
    <div class="cell" >
    Die 42er Projekte sind Semantische Datenmodelle. 
    Sie enthalten Basis oder Kundenspezifische Modelle welche die Basismodelle an die Bedüfnisse des Kunden anpassen.
    </div>
  </li>
  <li><span>Data Projekt</span> 
    <div class="cell" >
    Datenprojekte sind reine Dateispeicher.
    </div>
  </li>
  <li><span>Knowledge Base Projekt</span> 
    <div class="cell" >
      Knowledge Base Projekt enthalten Definitionsklassen für das BDL Modell.
      Über dieses Defitionsklassen werden die is_a Attribute in den EntityAttributen 
      definiert und interpretiert.
    </div>
  </li>
  <li><span>Cartridge Projekt</span> 
    <div class="cell" >
      Catridge-Projekte enthalten die Codetemplates für den Codegenerator
    </div>
  </li>
  <li><span>Theme Projekt</span> 
    <div class="cell" >
    </div>
  </li>
  <li><span>Icon Projekt</span> 
    <div class="cell" >
    </div>
  </li>
  <li><span>Wgt Projekt</span> 
    <div class="cell" >
    </div>
  </li>
  <li><span>Vendor Lib Projekt</span> 
    <div class="cell" >
    </div>
  </li>
</ul>