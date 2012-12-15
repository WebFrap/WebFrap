<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Daidalos',$this->interface.'?c=Daidalos.Base.menu','control/folder.png'),
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
    'places/folder_up.png',
  );



  /**/
  $this->files[] = array
  (
    'menu_mod_daidalos_deployment',
    Wgt::MAIN_TAB,
    'Deployment',
    'Deployment',
    'maintab.php?c=Daidalos.Base.menu&amp;menu=deployment',
    'utilities/deploy.png',
  );
  
  
  $this->files[] = array
  (
    'menu_mod_daidalos_database',
    Wgt::MAIN_TAB,
    'Database',
    'Database',
    'maintab.php?c=Daidalos.Db.listing',
    'utilities/db.png',
  );
  
  $this->files[] = array
  (
    'menu_mod_daidalos_bdl_modeller',
    Wgt::MAIN_TAB,
    'BDL Modeller',
    'BDL Modeller',
    'maintab.php?c=Daidalos.BdlModeller.listing',
    'utilities/modeller.png',
  );

  $this->files[] = array
  (
    'menu_developer_db_query',
    Wgt::MAIN_TAB,
    'Query Tester',
    'Query Tester',
    'maintab.php?c=Daidalos.Db.query',
    'places/entity.png',
  );

  $this->files[] = array
  (
    'menu_developer_status_editor',
    Wgt::MAIN_TAB,
    'System Status Editor',
    'System Status Editor',
    'maintab.php?c=Daidalos.System.statusEditior',
    'utilities/tools.png',
  );

  $this->files[] = array
  (
    'menu_developer_database',
    Wgt::MAIN_TAB,
    'Database Connections',
    'Database Connections',
    'maintab.php?c=Daidalos.Database.listConnections',
    'utilities/db.png',
  );

  
  $this->files[] = array
  (
    'menu_mod_daidalos_bugs',
    Wgt::MAIN_TAB,
    'Bugs',
    'Bugs',
    'maintab.php?c=Wbfsys.Issue.listing',
    'utilities/bug.png',
  );

  
  $this->files[] = array
  (
    'menu_mod_daidalos_dev_packager',
    Wgt::MAIN_TAB,
    'Package Creator',
    'Package Creator',
    'maintab.php?c=Daidalos.Package.workspace',
    'utilities/packer.png',
  );

}
