<?php

$this->crumbs = array(
  array('Root','maintab.php?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Daidalos','maintab.php?c=Daidalos.Base.menu','webfrap/module.png'),
);

$this->firstEntry = array
(
  'menu_webfrap_root',
  Wgt::WINDOW,
  '..',
  'Daidalos',
  'maintab.php?c=Daidalos.Base.menu',
  'places/folder_up.png',
);

$this->folders[] = array
(
  'menu_mod_daidalos_sync',
  Wgt::WINDOW,
  'Sync Metadata',
  'Sync Metadata',
  'maintab.php?c=Daidalos.Deploy.sycmetadata',
  'mimetypes/exec.png',
);




