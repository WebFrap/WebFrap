<?php

if( $acl->hasRole('developer') )
{

  $this->firstEntry = array
  (
    'menu_mod_developer',
    Wgt::WINDOW,
    '..',
    'developer menu',
    'maintab.php?c=daidalos.base.menu',
    'webfrap/category.png',
  );
  
  $this->files[] = array
  (
    'menu_developer_architecture_demo',
    Wgt::WINDOW,
    'Demo Architecture',
    'Demo Architecture',
    'index.php?c=Architecture.Demo.table',
    'webfrap/entity.png',
  );
  
  $this->files[] = array
  (
    'menu_developer_webfrap_architecture',
    Wgt::WINDOW,
    'WebFrap Architecture',
    'WebFrap Architecture',
    'index.php?c=Webfrap.Architecture.menu',
    'webfrap/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_arch_formsingle',
    Wgt::WINDOW,
    'form single',
    'form single',
    'index.php?c=developer.ArchCrud.formsingle',
    'webfrap/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_arch_formmulti',
    Wgt::WINDOW,
    'form multi',
    'form multi',
    'index.php?c=developer.ArchCrud.formmulti',
    'webfrap/entity.png',
  );
  
  
  $this->files[] = array
  (
    'menu_developer_playground_wgt',
    Wgt::WINDOW,
    'playground wgt',
    'playground wgt',
    'index.php?c=developer.Playground.Window&amp;key=wgt',
    'webfrap/entity.png',
  );

}