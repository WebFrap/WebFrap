<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Daidalos',$this->interface.'?c=Daidalos.Base.menu','control/folder.png'),
  array('Example',$this->interface.'?c=Example.Base.menu','control/folder.png'),
);

if ($acl->hasRole('developer') ) {

  $this->firstEntry = array
  (
    'menu_webfrap_root',
    Wgt::MAIN_TAB,
    '..',
    'Webfrap Root',
    'maintab.php?c=Daidalos.Base.menu',
    'places/folder_up.png',
  );

  $this->files[] = array
  (
    'menu_mod_example-wgt',
    Wgt::MAIN_TAB,
    'WGT',
    'WGT',
    'maintab.php?c=Example.Wgt.tree',
    'utilities/wgt.png',
  );

  $this->files[] = array
  (
    'menu_mod_example-tech',
    Wgt::MAIN_TAB,
    'Tech &amp; Libs',
    'Tech &amp; Libs',
    'maintab.php?c=Example.Tech.tree',
    'utilities/wgt.png',
  );

}
