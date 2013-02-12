<?php


if( $user->hasRole( array( 'admin', 'developer' ) ) )
{
  $this->folders[] = array
  (
    'menu-mod-webfrap-maintenance',
    Wgt::MAIN_TAB,
    I18n::s( 'System', 'maintenance.label'  ),
    I18n::s( 'System', 'maintenance.label'  ),
    'maintab.php?c=Webfrap.Base.menu&amp;menu=maintenance',
    'module/maintenance.png',
  );

}