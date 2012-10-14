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
    'webfrap/folder_up.png',
  );

  $this->folders[] = array
  (
    'menu_mod_daidalos_developer',
    Wgt::MAIN_TAB,
    'Developer',
    'Developer',
    'maintab.php?c=Daidalos.Base.menu&amp;menu=developer',
    'daidalos/developer.png',
  );

  $this->folders[] = array
  (
    'menu_mod_daidalos_maintenance',
    Wgt::MAIN_TAB,
    'Maintenance',
    'Maintenance',
    'maintab.php?c=daidalos.base.menu&amp;menu=maintenance',
    WgtIcon::big('daidalos/maintenance.png'),
  );
  
  
  
  // files
  /*
  $this->files[] = array
  (
    'menu_mod_daidalos_sync',
    Wgt::MAIN_TAB,
    'Sync Management',
    'Sync Management',
    'maintab.php?c=Daidalos.Sync.listing',
    'daidalos/sync.png',
  );

  $this->files[] = array
  (
    'menu_mod_daidalos_projects',
    Wgt::MAIN_TAB,
    I18n::s( 'Bdl Projects', 'genf.label'  ),
    I18n::s( 'Bdl Projects', 'genf.title'  ),
    'maintab.php?c=Daidalos.Projects.listing',
    'daidalos/logo_genf.png',
  );
  
  
  $this->files[] = array
  (
    'menu_mod_daidalos_repos',
    Wgt::MAIN_TAB,
    I18n::s( 'Code Repositories', 'genf.label'  ),
    I18n::s( 'Code Repositories', 'genf.title'  ),
    'maintab.php?c=Daidalos.CodeRepository.listing',
    'daidalos/code_repo.png',
  );
  *//*
  
  $this->files[] = array
  (
    'menu_mod_daidalos_workspaces',
    Wgt::MAIN_TAB,
    I18n::s( 'Workspaces', 'genf.label'  ),
    I18n::s( 'Workspaces', 'genf.title'  ),
    'maintab.php?c=Daidalos.Workspace.listing',
    'daidalos/workspace.png',
  );
  
  
  $this->files[] = array
  (
    'menu_mod_daidalos_remote',
    Wgt::MAIN_TAB,
    I18n::s( 'Remote', 'genf.label'  ),
    I18n::s( 'Remote', 'genf.title'  ),
    'maintab.php?c=Daidalos.Remote.listing',
    'daidalos/remote.png',
  );
  
  $this->files[] = array
  (
    'menu_mod_daidalos_editor',
    Wgt::MAIN_TAB,
    I18n::s( 'Code Editor', 'daidalos.label'  ),
    I18n::s( 'Code Editor', 'daidalos.title'  ),
    'maintab.php?c=Daidalos.Editor.Test',
    'daidalos/editor.code.png',
  );
  */
 
  
  /*
  $this->files[] = array
  (
    'menu_mod_daidalos_search',
    Wgt::MAIN_TAB,
    'Search',
    'Search',
    'maintab.php?c=Daidalos.Search.form',
    'daidalos/search.png',
  );
  */
  /**/
  $this->files[] = array
  (
    'menu_mod_daidalos_deployment',
    Wgt::MAIN_TAB,
    'Deployment',
    'Deployment',
    'maintab.php?c=Daidalos.Base.menu&amp;menu=deployment',
    'daidalos/deploy.png',
  );
  
  
  $this->files[] = array
  (
    'menu_mod_daidalos_database',
    Wgt::MAIN_TAB,
    'Database',
    'Database',
    'maintab.php?c=Daidalos.Db.listing',
    'daidalos/db.png',
  );
  
  $this->files[] = array
  (
    'menu_mod_daidalos_bdl_modeller',
    Wgt::MAIN_TAB,
    'BDL Modeller',
    'BDL Modeller',
    'maintab.php?c=Daidalos.BdlModeller.listing',
    'daidalos/modeller.png',
  );

  $this->files[] = array
  (
    'menu_developer_db_query',
    Wgt::WINDOW,
    'Query Tester',
    'Query Tester',
    'maintab.php?c=Daidalos.Db.query',
    'webfrap/entity.png',
  );

  $this->files[] = array
  (
    'menu_developer_status_editor',
    Wgt::WINDOW,
    'System Status Editor',
    'System Status Editor',
    'maintab.php?c=Daidalos.System.statusEditior',
    'daidalos/tools.png',
  );

  $this->files[] = array
  (
    'menu_developer_database',
    Wgt::WINDOW,
    'Database Connections',
    'Database Connections',
    'maintab.php?c=Daidalos.Database.listConnections',
    'daidalos/db.png',
  );

  $this->files[] = array
  (
    'menu_developer_acl',
    Wgt::WINDOW,
    'ACLs',
    'ACLs',
    'maintab.php?c=Daidalos.Acl.form',
    'module/acl.png',
  );
  
  $this->files[] = array
  (
    'menu_mod_daidalos_bugs',
    Wgt::MAIN_TAB,
    'Bugs',
    'Bugs',
    'maintab.php?c=Wbfsys.Issue.listing',
    'daidalos/bug.png',
  );

  
  $this->files[] = array
  (
    'menu_mod_daidalos_dev_packager',
    Wgt::MAIN_TAB,
    'Package Creator',
    'Package Creator',
    'maintab.php?c=Daidalos.Package.workspace',
    'daidalos/packer.png',
  );

}
