<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Admin',$this->interface.'?c=Webfrap.Maintenance.menu','control/folder.png'),
);

$this->firstEntry = array
(
  'menu_mod_root',
   Wgt::SUB_WINDOW,
  '..',
  I18n::s( 'Root', 'wbf.label'  ),
  'maintab.php?c=Webfrap.Navigation.explorer',
  WgtIcon::big('webfrap/folder.png'),
);

if( $acl->access( 'mod-wbfsys/entity-wbfsys_role_group>mgmt-wbfsys_role_group:listing', null, true ) )
{
  
  $this->files[] = array
  (
    'menu_mgmt_wbfsys_role_group',
    Wgt::SUB_WINDOW,
    $this->view->i18n->l
    (
      'Role Group',
      'wbfsys.role_group.label'
    ),
    $this->view->i18n->l
    (
      'Role Group',
      'wbfsys.role_group.label'
    ),
    'maintab.php?c=Wbfsys.RoleGroup.listing',
    WgtIcon::big('webfrap/entity.png'),
  );

}


if( $acl->access( 'mod-wbfsys/entity-wbfsys_profile>mgmt-wbfsys_profile:listing', null, true ) )
{

  $this->files[] = array
  (
    'menu_mgmt_wbfsys_profile',
    Wgt::SUB_WINDOW,
    $this->view->i18n->l
    (
      'Profile',
      'wbfsys.profile.label'
    ),
    $this->view->i18n->l
    (
      'Profile',
      'wbfsys.profile.label'
    ),
    'maintab.php?c=Wbfsys.Profile.listing',
    WgtIcon::big('webfrap/entity.png'),
  );

}

if( $acl->access( 'mod-wbfsys/entity-wbfsys_tag>mgmt-wbfsys_tag:listing', null, true ) )
{

  $this->files[] = array
  (
    'menu_mgmt_wbfsys_tag',
    Wgt::SUB_WINDOW,
    $this->view->i18n->l
    (
      'Tag',
      'wbfsys.tag.label'
    ),
    $this->view->i18n->l
    (
      'Tag',
      'wbfsys.tag.label'
    ),
    'maintab.php?c=Wbfsys.Tag.listing',
    WgtIcon::big('webfrap/entity.png'),
  );

}

if( $acl->access( 'mod-wbfsys/entity-wbfsys_help_page>mgmt-wbfsys_help_page:listing', null, true ) )
{
  
  $this->files[] = array
  (
    'menu_mgmt_wbfsys_help_page',
    Wgt::SUB_WINDOW,
    $this->view->i18n->l
    (
      'Help Page',
      'wbfsys.help_page.label'
    ),
    $this->view->i18n->l
    (
      'Help Page',
      'wbfsys.help_page.label'
    ),
    'maintab.php?c=Wbfsys.HelpPage.listing',
    WgtIcon::big('webfrap/entity.png'),
  );

}

if( $acl->access( 'mod-wbfsys/entity-wbfsys_role_user>mgmt-wbfsys_role_user:listing', null, true ) )
{
  
  $this->files[] = array
  (
    'menu_mgmt_wbfsys_role_user',
    Wgt::SUB_WINDOW,
    $this->view->i18n->l
    (
      'User Role',
      'wbfsys.role_user.label'
    ),
    $this->view->i18n->l
    (
      'User Role',
      'wbfsys.role_user.label'
    ),
    'maintab.php?c=Wbfsys.RoleUser.listing',
    WgtIcon::big('webfrap/entity.png'),
  );

}

