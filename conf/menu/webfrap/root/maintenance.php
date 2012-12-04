<?php

$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
);


if( $user->hasRole( array( 'admin', 'developer' ) ) )
{
  $this->folders[] = array
  (
    'menu_mod_maintenance',
    Wgt::MAIN_TAB,
    I18n::s( 'Maintenance', 'maintenance.label'  ),
    I18n::s( 'Maintenance', 'maintenance.label'  ),
    'maintab.php?c=Webfrap.Maintenance.menu',
    WgtIcon::big('module/maintenance.png'),
  );

}