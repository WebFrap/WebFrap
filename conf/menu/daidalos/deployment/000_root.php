<?php

$this->firstEntry = array
(
  'menu_webfrap_root',
  Wgt::MAIN_TAB,
  '..',
  'Daidalos',
  'maintab.php?c=Daidalos.Base.menu',
  WgtIcon::big('places/folder_up.png'),
);

$this->folders[] = array
(
  'menu_mod_daidalos_sync_medata',
  Wgt::MAIN_TAB,
  'Sync Metadata',
  'Sync Metadata',
  'maintab.php?c=Daidalos.Deploy.syncMetadata',
  WgtIcon::big('mimetypes/exec.png'),
);

$this->folders[] = array
(
  'menu_mod_daidalos_sync_db',
  Wgt::MAIN_TAB,
  'Update Database',
  'Update Database',
  'maintab.php?c=Daidalos.Deploy.syncDatabase',
  WgtIcon::big('mimetypes/exec.png'),
);

$this->folders[] = array
(
  'menu_mod_daidalos_sync_data',
  Wgt::MAIN_TAB,
  'Sync Data',
  'Sync Data',
  'maintab.php?c=Daidalos.Deploy.syncData',
  WgtIcon::big('mimetypes/exec.png'),
);


$this->folders[] = array
(
  'menu_mod_daidalos_fix',
  Wgt::MAIN_TAB,
  'Fix System Issues',
  'Fix System Issues',
  'maintab.php?c=Daidalos.Base.menu&amp;menu=fixes',
  WgtIcon::big('places/folder.png'),
);



