<h1>Access Control Lists</h1>

<p>Über die ACLs können komplexe Zugriffszenarien abgebildet werden.</p>

<p>
Der Erste Schritt ist das Zuweisen von Berechtigungen (Setzen eines Access-Levels) 
auf Rollen für eine Security Area.
</p>

<img src="./images/buiz_guidance/acl/acl_roles.png" class="block" alt="Acl Roles" />

<p>
Die Vergabe der Berechtigungen an Benutzer erfolgt dann über die Gruppenzugehörigkeit
des Benutzers. Im Abschnitt Roles wird beschrieben, dass es direkte aber auch relative
Gruppenzugehörigkeiten geben kann.
</p>

<img src="./images/buiz_guidance/acl/acl_assignments.png" class="block" alt="Acl Assignments" />

<p>
Admin hat in Relation zum "Projekt Planning" Management Knoten die Rolle admin. 
Daher hat er alle Rechte bis zum Access-Level admin, für alle Projekte innerhalb
des Management Knotens. 
</p>

<p>
Hans hat in Relation zu dem Projekt "Das Projekt" die Rolle owner, 
er hat für genau dieses Projekt alle Rechte bis zum Access-Level delete.
</p>

<p>
Berta hat ebenfalls in Relation zu dem Projekt die Rolle staff, kann aber auf Grund 
der niedrigeren Berechtigungen nur das Projekt zum lesen öffnen.
</p>
