<?php

if ($acl->hasRole('developer')) {

  $this->folders[] = array
  (
    'menu_mod_daidalos',
    Wgt::MAIN_TAB,
    I18n::s('Daidalos', 'daidalos.label'  ),
    I18n::s('Daidalos', 'daidalos.label'  ),
    'maintab.php?c=Daidalos.base.menu',
    'module/daidalos.png',
  );

}