<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
  array( 'Exports', $this->interface.'?c=Webfrap.Base.menu&amp;menu=exports','control/folder.png'),
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




