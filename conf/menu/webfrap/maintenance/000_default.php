<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
);

$this->firstEntry = array
(
  'menu-system-maintenance-root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s( 'Root', 'wbf.label'  ),
  'maintab.php?c=Webfrap.Navigation.explorer',
  'places/folder_up.png',
);

$this->files[] = array
(
  'menu-system-maintenance-cache',
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
  'menu-system-maintenance-theme',
  Wgt::MAIN_TAB,
  'Themes',
  'Themes',
  'maintab.php?c=Daidalos.Theme.form',
  'utilities/colors.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-backup',
  Wgt::MAIN_TAB,
  'Backups',
  'Backups',
  'maintab.php?c=daidalos.base.menu&amp;menu=backup',
  'utilities/backup.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-conf',
  Wgt::MAIN_TAB,
  'Conf',
  'Conf',
  'maintab.php?c=Webfrap.Maintenance_Conf.overview',
  'utilities/conf.png',
);



$this->folders[] = array
(
  'menu-system-maintenance-index',
  Wgt::MAIN_TAB,
  'Semantic Index',
  'Semantic Index',
  'maintab.php?c=Maintenance.Db_Index.stats',
  'utilities/index.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-manager',
  Wgt::MAIN_TAB,
  'Package Manager',
  'Package Manager',
  'maintab.php?c=Maintenance.Packages.listAll',
  'utilities/package_manager.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-imports',
  Wgt::MAIN_TAB,
  'Imports',
  'Imports',
  'maintab.php?c=Webfrap.Base.Menu&menu=imports',
  'utilities/import.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-exports',
  Wgt::MAIN_TAB,
  'Exports',
  'Exports',
  'maintab.php?c=Webfrap.Base.Menu&menu=exports',
  'utilities/export.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-coredata',
  Wgt::MAIN_TAB,
  'Core Data',
  'Core Data',
  'maintab.php?c=Webfrap.Base.Menu&menu=masterdata',
  'utilities/master_data.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-access',
  Wgt::MAIN_TAB,
  'Access',
  'Access',
  'maintab.php?c=Webfrap.Base.Menu&menu=access',
  'utilities/access.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-process_manager',
  Wgt::MAIN_TAB,
  'Process Manager',
  'Process Manager',
  'maintab.php?c=Webfrap.Maintenance_Process.list',
  'utilities/process.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-planned-tasks',
  Wgt::MAIN_TAB,
  'Planned Tasks',
  'Planned Tasks',
  'maintab.php?c=Webfrap.TaskPlanner.list',
  'utilities/planned_tasks.png',
);

$this->folders[] = array
(
  'menu-system-maintenance-announcements',
  Wgt::MAIN_TAB,
  'News',
  'News',
  'maintab.php?c=Webfrap.Announcement.listing',
  'utilities/announcements.png',
);

$this->files[] = array
(
  'menu-system-maintenance-protocol',
  Wgt::MAIN_TAB,
  'Protocols &amp; Logs',
  'Protocols &amp; Logs',
  'maintab.php?c=Webfrap.Base.menu&amp;menu=protocols',
  'utilities/protocol.png',
);

$this->files[] = array
(
  'menu-system-maintenance-database',
  Wgt::MAIN_TAB,
  'Database',
  'Database',
  'maintab.php?c=Webfrap.Base.menu&amp;menu=database',
  'utilities/db.png',
);

$this->files[] = array
(
  'menu-system-maintenance-editor',
  Wgt::MAIN_TAB,
  'Editor',
  'Editor',
  'maintab.php?c=Webfrap.Editor.Workspace',
  'utilities/editor.png',
);

$this->files[] = array
(
  'menu-system-maintenance-i18n',
  Wgt::MAIN_TAB,
  'I18n',
  'I18n',
  'maintab.php?c=Webfrap.Editor.Workspace',
  'utilities/i18n.png',
);

$this->files[] = array
(
  'menu-system-maintenance-services',
  Wgt::MAIN_TAB,
  'External Datasources',
  'External Datasources',
  'ajax.php?c=Webfrap.Mockup.notYetImplemented',
  //'maintab.php?c=Webfrap.Datasources.explorer',
  'utilities/services.png',
);

$this->files[] = array
(
  'menu-system-maintenance-status',
  Wgt::MAIN_TAB,
  'System Status',
  'System Status',
  'maintab.php?c=Webfrap.System_Status.stats',
  'utilities/status.png',
);

