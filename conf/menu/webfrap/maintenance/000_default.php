<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
);

$this->firstEntry = array
(
  'menu_mod_root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s( 'Root', 'wbf.label'  ),
  'maintab.php?c=Webfrap.Navigation.explorer',
  'places/folder.png',
);

$this->files[] = array
(
  'menu-system-cache',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Cache',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Cache',
    'wbf.label'
  ),
  'maintab.php?c=Webfrap.Cache.stats',
  'utilities/cache.png',
);

$this->files[] = array
(
  'menu-system-theme',
  Wgt::MAIN_TAB,
  'Themes',
  'Themes',
  'maintab.php?c=Daidalos.Theme.form',
  'utilities/colors.png',
);

$this->folders[] = array
(
  'menu-system-backup',
  Wgt::MAIN_TAB,
  'Backups',
  'Backups',
  'maintab.php?c=daidalos.base.menu&amp;menu=backup',
  'utilities/backup.png',
);

$this->folders[] = array
(
  'menu-system-conf',
  Wgt::MAIN_TAB,
  'Conf',
  'Conf',
  'maintab.php?c=Webfrap.Maintenance_Conf.overview',
  'utilities/conf.png',
);

$this->files[] = array
(
  'menu-system-db-consistency',
  Wgt::AJAX,
  'Db Concistency',
  'Db Concistency',
  'maintab.php?c=Maintenance.DbConsistency.table',
  'utilities/db.png',
);

$this->folders[] = array
(
  'menu-system-index',
  Wgt::MAIN_TAB,
  'Semantic Index',
  'Semantic Index',
  'maintab.php?c=Maintenance.Db_Index.stats',
  'utilities/index.png',
);

$this->folders[] = array
(
  'menu-system-manager',
  Wgt::MAIN_TAB,
  'Package Manager',
  'Package Manager',
  'maintab.php?c=Maintenance.Packages.listAll',
  'utilities/package_manager.png',
);

$this->folders[] = array
(
  'menu-system-imports',
  Wgt::MAIN_TAB,
  'Imports',
  'Imports',
  'maintab.php?c=Webfrap.Base.Menu&menu=imports',
  'utilities/import.png',
);

$this->folders[] = array
(
  'menu-system-coredata',
  Wgt::MAIN_TAB,
  'Core Data',
  'Core Data',
  'maintab.php?c=Webfrap.Base.Menu&menu=masterdata',
  'utilities/master_data.png',
);

$this->folders[] = array
(
  'menu-system-access',
  Wgt::MAIN_TAB,
  'Access',
  'Access',
  'maintab.php?c=Webfrap.Base.Menu&menu=access',
  'utilities/access.png',
);

$this->folders[] = array
(
  'menu-system-process_manager',
  Wgt::MAIN_TAB,
  'Process Manager',
  'Process Manager',
  'maintab.php?c=Webfrap.Maintenance_Process.list',
  'utilities/process.png',
);

$this->folders[] = array
(
  'menu-system-planned-tasks',
  Wgt::MAIN_TAB,
  'Planned Tasks',
  'Planned Tasks',
  'maintab.php?c=Webfrap.PlannedTask.list',
  'utilities/planned_tasks.png',
);

$this->folders[] = array
(
  'menu-system-announcements',
  Wgt::MAIN_TAB,
  'News',
  'News',
  'maintab.php?c=Webfrap.Announcement.listing',
  'utilities/announcements.png',
);

$this->files[] = array
(
  'menu-system-protocol',
  Wgt::MAIN_TAB,
  'Protocols',
  'Protocols',
  'maintab.php?c=Webfrap.Base.menu&amp;menu=protocols',
  'utilities/protocol.png',
);

