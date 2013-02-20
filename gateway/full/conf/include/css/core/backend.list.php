<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

echo '@charset "utf-8";'.NL;

$files = array
(

  // wgt css framework
  PATH_WGT.'layout/default/wgt/wgt.core.css',
  PATH_WGT.'layout/default/wgt/wgt.text.css',
  PATH_WGT.'layout/default/wgt/wgt.tab.css',
  PATH_WGT.'layout/default/wgt/wgt.boxes.css',
  PATH_WGT.'layout/default/wgt/wgt.panel.css',
  PATH_WGT.'layout/default/wgt/wgt.form.css',
  PATH_WGT.'layout/default/wgt/wgt.menu.css',
  PATH_WGT.'layout/default/wgt/wgt.menuselector.css',
  PATH_WGT.'layout/default/wgt/wgt.window.css',
  PATH_WGT.'layout/default/wgt/wgt.footer.css',
  PATH_WGT.'layout/default/wgt/wgt.table.css',
  PATH_WGT.'layout/default/wgt/wgt.tree.css',
  PATH_WGT.'layout/default/wgt/wgt.grid.css',
  PATH_WGT.'layout/default/wgt/wgt.list.css',
  PATH_WGT.'layout/default/wgt/wgt.dropform.css',
  PATH_WGT.'layout/default/wgt/wgt.process_form.css',

  // wgt ui classes
  PATH_WGT.'layout/default/wgt/wgt.ui.tip.css',

  PATH_WGT.'layout/default/jquery_ui/jquery.ui.core.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.accordion.css',
  //PATH_WGT.'layout/default/jquery_ui/jquery.ui.base.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.button.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.progressbar.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.selectable.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.dialog.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.resizable.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.slider.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.tabs.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.datepicker.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.menu.css',
  PATH_WGT.'layout/default/jquery_ui/jquery.ui.autocomplete.css',

  // jquery plugins
  PATH_WGT.'layout/default/jquery/jquery.autocomplete.css',
  PATH_WGT.'layout/default/jquery/jquery.tooltip.css',
  PATH_WGT.'layout/default/jquery/jquery.rating.css',
  PATH_WGT.'layout/default/jquery/jquery.dropmenu.css',
  PATH_WGT.'layout/default/jquery/jquery.toaster.css',
  PATH_WGT.'layout/default/jquery/jquery.treeview.css',

  // layout
  PATH_WGT.'layout/default/layout/layout.full.css',

);

if ( DEBUG )
  $files[] = PATH_WGT.'layout/default/wgt/wgt.developer.css';

foreach ($files as $file) {
  include $file;
  echo NL;
}
