<?php

if( $acl->hasRole('developer') )
{

  $this->firstEntry = array
  (
    'menu_mod_maintenance',
     Wgt::WINDOW,
    '..',
    I18n::s( 'Maintenance', 'maintenance.title'  ),
    'maintab.php?c=maintenance.base.menu',
    WgtIcon::big('webfrap/folder.png'),
  );
  
  $this->folders[] = array
  (
    'menu_mod_maintenance_backup_db',
    Wgt::WINDOW,
    'backup db',
    I18n::s( 'backup', 'admin.title'  ),
    'index.php?c=Daidalos.BackupDb.table',
    WgtIcon::big('maintenance/db_backup.png'),
  );

}
