<?php



$this->files[] = array
(
  'menu_mod_maintenance_import',
  Wgt::MAIN_TAB,
  I18n::s( 'Import', 'admin.label'  ),
  I18n::s( 'Import', 'admin.title'  ),
  'maintab.php?c=maintenance.base.menu&amp;menu=imports',
  'utilities/db_import.png',
);

$this->files[] = array
(
  'menu_mod_maintenance_sync',
  Wgt::MAIN_TAB,
  'Sync',
  'Sync',
  'maintab.php?c=maintenance.base.menu&amp;menu=sync',
  'utilities/db_import.png',
);

$this->files[] = array
(
  'menu_mod_maintenance_backup',
  Wgt::MAIN_TAB,
  I18n::s( 'Backup', 'admin.label'  ),
  I18n::s( 'Backup', 'admin.title'  ),
  'maintab.php?c=maintenance.base.menu&amp;menu=backup',
  'utilities/db_backup.png',
);

