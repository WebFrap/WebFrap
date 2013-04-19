<h1>Folders</h1>

<h3>./cache</h3>

<p>Rootpfad für alle Filebased caches im System</p>

<ul class="doc-tree" >
  <li><span>cache/app_theme</span></li>
  <li><span>cache/autoload</span></li>
  <li><span>cache/css</span></li>
  <li><span>cache/db_resources</span></li>
  <li><span>cache/i18n</span></li>
  <li><span>cache/javascript</span></li>
</ul>

<h3>./data</h3>

<p>Speicherort für daten des Systems. Darf nicht direkt vom Browser addressiert werden.</p>
<p>Hier finden sich (Dokument) Vorlagen, Uploads, XML Dateien usw.</p>

<h3>./files</h3>

<p>Public files welche auch vom Browser aus adressierbar sein können.</p>
<p>Files ist quasi der Ordner für die nicht layout statischen Dateien des Systems.</p>

<h3>./tmp</h3>

<p>Nicht persistente Temporäre Dateien. Hier darf der Browser auf keine Umständen lesend zugreifen können.</p>
<p>Bei der Standarddefinition werden hier auch die Sessions gespeichert.</p>
