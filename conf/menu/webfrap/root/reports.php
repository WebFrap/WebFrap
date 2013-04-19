<?php

if ($user->hasRole(array('admin','developer'))) {

  $this->folders[] = array
  (
    'menu_mod_reports',
    Wgt::MAIN_TAB,
    I18n::s('Reports', 'report.label'  ),
    I18n::s('Reports', 'report.label'  ),
    'maintab.php?c=report.base.menu',
    WgtIcon::big('module/report.png'),
  );

}