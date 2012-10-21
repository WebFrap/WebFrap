<?php


$this->crumbs = array(
  array('Root',$this->interface.'?c=Webfrap.Navigation.explorer','control/desktop.png'),
  array('Daidalos',$this->interface.'?c=Daidalos.Base.menu','control/folder.png'),
  array('Developer',$this->interface.'?c=Daidalos.Base.menu&amp;menu=developer','utilities/developer.png'),
);


// zugriff auf daidalos prüfen
$access = $acl->getPermission( 'mod-daidalos' );

if( $access->access )
{

  $this->firstEntry = array
  (
    'menu_webfrap_root',
    Wgt::WINDOW,
    '..',
    'webfrap root',
    'maintab.php?c=daidalos.base.menu',
    'places/category.png',
  );

  $this->files[] = array
  (
    'menu_mod_daidalos_mail_tester',
    Wgt::MAIN_TAB,
    'Mail Tester',
    'Mail Tester',
    'maintab.php?c=Daidalos.Mail.form',
    'module/mail.png',
  );

  $this->files[] = array
  (
    'menu_mod_daidalos_dev_periodic',
    Wgt::MAIN_TAB,
    'Periodic Tester',
    'Periodic Tester',
    'maintab.php?c=Daidalos.Dev_Periodic.form',
    'module/calendar.png',
  );

  $this->files[] = array
  (
    'menu_mod_daidalos_dev_heidelpay',
    Wgt::MAIN_TAB,
    'Heidelpay Tester',
    'Heidelpay Heidelpay',
    'maintab.php?c=Daidalos.Dev_Heidelpay.form',
    'else/money.png',
  );
  
}
