<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
  array( 'Database', $this->interface.'?c=Webfrap.Base.menu&amp;menu=database','control/folder.png'),
);

$this->firstEntry = array
(
  'menu_mod_root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s( 'Root', 'wbf.label'  ),
  'maintab.php?c=Webfrap.Base.menu&amp;menu=maintenance',
  'places/folder_up.png',
);

$this->files[] = array
(
  'menu-system-maintenance-db-consistency',
  Wgt::AJAX,
  'Db Concistency',
  'Db Concistency',
  'maintab.php?c=Maintenance.DbConsistency.table',
  'utilities/db.png',
);
