<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Example',$this->interface.'?c=Example.Base.menu','control/folder.png'),
);


if( $acl->hasRole('developer') )
{

  $this->firstEntry = array
  (
    'menu_webfrap_root',
    Wgt::MAIN_TAB,
    '..',
    'Webfrap Root',
    'maintab.php?c=Webfrap.Navigation.explorer',
    'webfrap/folder_up.png',
  );

  $this->folders[] = array
  (
    'menu_mod_example_commenttree',
    Wgt::MAIN_TAB,
    'Comment Tree',
    'Comment Tree',
    'maintab.php?c=Example.CommentTree.shop',
    'control/mask.png',
  );


}
