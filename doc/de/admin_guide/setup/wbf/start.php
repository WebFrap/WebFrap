<h1>Grundstruktur</h1>

<p>
Gibt es mehrere Universen? Für WebFrap basierte Projekte lässt sich diese 
Frage mit ja beantworten.
</p>

<p>
Die Konvention sieht vor, dass alle zusammenhängenden Projekte auf einem 
Server unterhalb eines Ordners namens: /srv/universe/{Name des Universums/Einer Daten-Zone}.
Ein Universum ist definiert als ein abgeschoteter Bereich welcher auf die jeweils gleiche Datenbasis zugreift.
Anderst formuliert bilden alle zusammengehörenden Datenknoten (Datenbanken, Caches, Dateien) ein Universum.<br />
Auf die Praxis übertragen sind z.B. alle Datenbanken / Fileserver / sonstige Datenspeicher innerhalb einer Firma, 
der Wahrnemungshorizont dieser Firma, eben das Datenuniversum.<br />
Somit hat jede Firma ein eigene Virtuelle Welt mit eigenen Erkentnissen und Regeln.
</p>


<label>Datenstruktur am Beispiel des Demo Projektes</label>

<?php start_highlight(); ?>
# Enthält das Gateway Projekt
# kann zusätzlich WebFrap_Wgt sowie Theme und Icon Projekte enthalten
# Sobald mehr als ein Gateway vorhanden ist, wird jedoch empfohlen
# diese Projekte in Separate Ordner auszulagern
/srv/universe/demo/WebFrap_Gw_Demo  

# Enthält WebFrap, WebFrap_Pontos, WebFrap_Daidalos, WebFrap_Plutos
/srv/universe/demo/WebFrap_Core      

# Das Wgt Projekt
/srv/universe/demo/WebFrap_Wgt

# Enthält alle vorhandenen Theme sowie Icon Themes Projekte
/srv/universe/demo/Themes

# Die Business Logik der Applikation
/srv/universe/demo/WebFrap_App_Demo

# Alle Vendor Bibliotheken welche auch nach dem Deployment getrennt vom
# WebFrap Code gelagert werden sollen 
/srv/universe/demo/Vendor

# Vendor Projekte können auch einzelln abgelegt werden, so kann genauer definiert
# werden in welchen Gateways welche Bibliotheken verwendet werden
/srv/universe/demo/WebFrap_Lib_FPDF

# Weiter ist es möglich verschiedenen Version abzulegen
/srv/universe/demo/WebFrap_Lib_FPDF_V2_0_1
<?php display_highlight( 'bash' ); ?>


<label>Datenstruktur SAAS Knoten</label>

<p>
Auf SAAS Knoten bekommt jeder Kunde seinen eigenen Knoten, auch wenn
es theoretisch möglich wäre alle Kunden ohne, dass diese es je bemerken, oder
negative Folgen zu befürchten hätten in einem Universum zu betreiben.
</p>

<?php start_highlight(); ?>
# Universum Kunde 1
/srv/universe/kd_1

# Universum Kunde 2
/srv/universe/kd_2

# Universum Kunde 3
/srv/universe/kd_3

# ok ab jetzt sollte das Muster bekannt sein
<?php display_highlight( 'bash' ); ?>


<label>Setup Script</label>

<?php start_highlight(); ?>
# Universum Kunde 1
/srv/universe/kd_1

# Universum Kunde 2
/srv/universe/kd_2

# Universum Kunde 3
/srv/universe/kd_3

# ok ab jetzt sollte das Muster bekannt sein
<?php display_highlight( 'php' ); ?>