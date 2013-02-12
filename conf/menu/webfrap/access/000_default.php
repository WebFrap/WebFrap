<?php

$this->crumbs = array(
  array( 'Root', $this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array( 'System', $this->interface.'?c=Webfrap.Base.menu&amp;menu=maintenance','control/folder.png'),
  array( 'Access', $this->interface.'?c=Webfrap.Base.menu&amp;menu=access','control/folder.png'),
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
  'menu-system-access-users',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Users',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Users',
    'wbf.label'
  ),
  'maintab.php?c=Wbfsys.RoleUser.listing',
  'module/users.png',
);

$this->files[] = array
(
  'menu-system-access-groups',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Groups',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Groups',
    'wbf.label'
  ),
  'maintab.php?c=Wbfsys.RoleGroup.listing',
  'module/groups.png',
);

$this->files[] = array
(
  'menu-system-access-profiles',
  Wgt::MAIN_TAB,
  $this->view->i18n->l
  (
    'Profiles',
    'wbf.label'
  ),
  $this->view->i18n->l
  (
    'Profiles',
    'wbf.label'
  ),
  'maintab.php?c=Wbfsys.Profile.listing',
  'module/profiles.png',
);

$this->files[] = array
(
  'menu-system-acl',
  Wgt::MAIN_TAB,
  'ACLs',
  'ACLs',
  'maintab.php?c=Daidalos.Acl.form',
  'module/acl.png',
);
