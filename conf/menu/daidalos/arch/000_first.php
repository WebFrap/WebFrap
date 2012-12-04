<?php

if( $acl->hasRole('developer') )
{

  $this->firstEntry = array
  (
    'menu_mod_developer',
    Wgt::MAIN_TAB,
    '..',
    'developer menu',
    'maintab.php?c=daidalos.base.menu',
    'places/category.png',
  );
  
  $this->files[] = array
  (
    'menu_developer_architecture_demo',
    Wgt::MAIN_TAB,
    'Demo Architecture',
    'Demo Architecture',
    'index.php?c=Architecture.Demo.table',
    'places/entity.png',
  );
  
  $this->files[] = array
  (
    'menu_developer_webfrap_architecture',
    Wgt::MAIN_TAB,
    'WebFrap Architecture',
    'WebFrap Architecture',
    'index.php?c=Webfrap.Architecture.menu',
    'places/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_arch_formsingle',
    Wgt::MAIN_TAB,
    'form single',
    'form single',
    'index.php?c=developer.ArchCrud.formsingle',
    'places/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_arch_formmulti',
    Wgt::MAIN_TAB,
    'form multi',
    'form multi',
    'index.php?c=developer.ArchCrud.formmulti',
    'places/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_playground_wgt',
    Wgt::MAIN_TAB,
    'playground wgt',
    'playground wgt',
    'index.php?c=developer.Playground.Window&amp;key=wgt',
    'places/entity.png',
  );

}