<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Maintenance',$this->interface.'?c=Webfrap.Maintenance.menu','control/folder.png'),
);

$this->firstEntry = array
(
  'menu_mod_root',
   Wgt::SUB_WINDOW,
  '..',
  I18n::s( 'Root', 'wbf.label'  ),
  'maintab.php?c=Webfrap.Navigation.explorer',
  'places/folder.png',
);

$this->files[] = array
(
  'menu_maintenance_cache',
  Wgt::SUB_WINDOW,
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
  'maintab.php?c=Maintenance.Cache.stats',
  'utilities/cache.png',
);

$this->files[] = array
(
  'menu_maintenance_theme',
  Wgt::WINDOW,
  'Themes',
  'Themes',
  'maintab.php?c=Daidalos.Theme.form',
  'utilities/colors.png',
);

$this->folders[] = array
(
  'menu_maintenance_backup',
  Wgt::WINDOW,
  'Backups',
  'Backups',
  'maintab.php?c=daidalos.base.menu&amp;menu=backup',
  'utilities/backup.png',
);

$this->folders[] = array
(
  'menu_maintenance_conf',
  Wgt::MAIN_TAB,
  'Conf',
  'Conf',
  'maintab.php?c=Webfrap.Maintenance_Conf.overview',
  'utilities/conf.png',
);

$this->folders[] = array
(
  'menu_maintenance_index',
  Wgt::MAIN_TAB,
  'Semantic Index',
  'Semantic Index',
  'maintab.php?c=Maintenance.Db_Index.stats',
  'utilities/index.png',
);

$this->folders[] = array
(
  'menu_maintenance_mod-manager',
  Wgt::MAIN_TAB,
  'Package Manager',
  'Package Manager',
  'maintab.php?c=Maintenance.Packages.listAll',
  'utilities/package_manager.png',
);


