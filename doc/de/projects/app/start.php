
<h1>Applikation / Modulprojekte</h1>

<h2>Beschreibung</h2>

<p>
App/Mod Projekte enthalten die die Business Logik einer Applikation.<br />
Darunter fallen die CRUD Layer für die Entites, Listen, Tabellen, Grids etc.
Darüber hinaus enthalten sie die ACL verwaltung, Reports, Prozesse sowie
Modulspezifische Profile, Desktops, Widgets sowie alle vergleichbaren Programmelemente.
Darüber hinaus noch Templates, Menüs, I18n Dateien sowie Modulspezifische Konfigurationsdateien.
</p>

<p>
Explizit nicht enthalten ist technische Logik wie z.B. ein Datenbank Klasse,
Bibliotheken zum erzeugen von PDF, Doc, Excel whatever.
Allgemeine Logik in Form von Formeln welche nicht speziell ausschlieslich für diesen
Code geschrieben wurden. <br />
Für technischen Code sind das Framework oder Lib Projekte gedacht. 
</p>

<p>
Ebenfalls nicht enthalten sein dürfen JavaScript und Css, Icons, Images oder
sonstige Dateien die später direkt adressiert werden müssen. 
Bei dem Deployment muss es möglich sein die App/Mod Projekte beliebig ineinander
zu kopieren, somit ist es nichtmehr möglich den Pfad in dem diese Dateien sich befinden
würden zu bestimmen.
</p>


<h2>Namensschema</h2>

<p>
  <span>ProjectName_Mod|App_Domainname</span>
</p>

<label>God</label>
<ul>
  <li>SDB_App_SBiz</li>
  <li>SDB_Mod_Project</li>
  <li>SDB_Mod_SBiz_Project</li>
</ul>

<label>Bad</label>
<ul>
  <li><strike>SDB_SBiz_App</strike></li>
  <li><strike>SDB_Project</strike></li>
  <li><strike>SDB_SBiz_Mod_Project</strike></li>
  <li><strike>SDB_Mod_Project_SBiz</strike></li>
</ul>
