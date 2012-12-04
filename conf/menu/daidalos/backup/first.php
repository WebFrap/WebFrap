<?php

if( $acl->hasRole('developer') )
{

  $this->firstEntry = array
  (
    'menu_mod_maintenance',
     Wgt::MAIN_TAB,
    '..',
    I18n::s( 'Maintenance', 'maintenance.title'  ),
    'maintab.php?c=maintenance.base.menu',
    WgtIcon::big('places/folder.png'),
  );
  
  $this->folders[] = array
  (
    'menu_mod_maintenance_backup_db',
    Wgt::MAIN_TAB,
    'backup db',
    I18n::s( 'backup', 'admin.title'  ),
    'index.php?c=Daidalos.BackupDb.table',
    WgtIcon::big('utilities/db_backup.png'),
  );

}
