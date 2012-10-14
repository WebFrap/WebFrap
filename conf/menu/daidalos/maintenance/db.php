<?php



$this->files[] = array
(
  'menu_mod_maintenance_import',
  Wgt::WINDOW,
  I18n::s( 'Import', 'admin.label'  ),
  I18n::s( 'Import', 'admin.title'  ),
  'maintab.php?c=maintenance.base.menu&amp;menu=imports',
  'maintenance/db_import.png',
);

$this->files[] = array
(
  'menu_mod_maintenance_sync',
  Wgt::WINDOW,
  'Sync',
  'Sync',
  'maintab.php?c=maintenance.base.menu&amp;menu=sync',
  'maintenance/db_import.png',
);

$this->files[] = array
(
  'menu_mod_maintenance_backup',
  Wgt::WINDOW,
  I18n::s( 'Backup', 'admin.label'  ),
  I18n::s( 'Backup', 'admin.title'  ),
  'maintab.php?c=maintenance.base.menu&amp;menu=backup',
  'maintenance/db_backup.png',
);

$this->files[] = array
(
  'menu_mod_maintenance_consistency',
  Wgt::AJAX,
  'Db Concistency',
  'Db Concistency',
  'maintab.php?c=Maintenance.DbConsistency.table',
  'maintenance/db.png',
);