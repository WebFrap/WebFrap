<h1>Explicit Permissions</h1>


<label>loadNumUserExplicit</label>
<p>
Auslesen der Anzahl explizit zugewiesener User in Relation zu einer Liste von
Datensätzen und Rollen.
</p>
<?php start_highlight(); ?>

$areas = 'mod-project/mgmt-project_project';

$roles = array
(
  'project_manager',
  'staff',
);

$datasets = array
(
  42,1337,4711
);

$numRoles = $acl->loadNumUserExplicit( $areas, $datasets, $roles );

// Anzahl User mit der Rolle Staff auf Datensatz 42
echo $numRoles[42]['staff'];

<?php display_highlight( 'php' ); ?>