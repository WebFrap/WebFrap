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

$jsconf = PATH_GW.'js_conf/conf.js';

$files = array
(

  // extend javascript
  PATH_WGT.'js_src/ext/ext.js.js',

  PATH_WGT.'js_src/jquery.js',
  PATH_WGT.'js_src/ext/ext.jquery.js',

  PATH_WGT.'js_src/wgt.js',

  // add i18n data
  PATH_WGT.'js_src/wgt/wgt.i18n.js',
  PATH_WGT.'js_src/i18n/i18n.de.js',

  // jquery plugins
  PATH_WGT.'js_src/jquery/jquery.sizes.js',
  PATH_WGT.'js_src/jquery/jquery.toaster.js',
  PATH_WGT.'js_src/jquery/jquery.dropmenu.js',
  PATH_WGT.'js_src/jquery/jquery.fullcalendar.js',
  PATH_WGT.'js_src/jquery/jquery.treeview.js',
  PATH_WGT.'js_src/jquery/jquery.treeTable.js',
  PATH_WGT.'js_src/jquery/jquery.tooltip.js',
  PATH_WGT.'js_src/jquery/jquery.monthpicker.js',

  // add jquery ui components
  PATH_WGT.'js_src/jquery/ui/ui.core.js',
  PATH_WGT.'js_src/jquery/ui/ui.draggable.js',
  PATH_WGT.'js_src/jquery/ui/ui.droppable.js',
  PATH_WGT.'js_src/jquery/ui/ui.dialog.js',
  PATH_WGT.'js_src/jquery/ui/ui.progressbar.js',
  PATH_WGT.'js_src/jquery/ui/ui.selectable.js',
  PATH_WGT.'js_src/jquery/ui/ui.datepicker.js',
  PATH_WGT.'js_src/jquery/ui/ui.accordion.js',

  // add wgt jquery plugins
  PATH_WGT.'js_src/jquery/wgt/jquery.wgt.menuselector.js',
  PATH_WGT.'js_src/jquery/wgt/jquery.wgt.miniMenu.js',
  PATH_WGT.'js_src/jquery/wgt/jquery.wgt.ajaxfileupload.js',

  // add windows
  PATH_WGT.'js_src/wgt/wgt.window.js',
  PATH_WGT.'js_src/wgt/window/wgt.window.bookmark.js',

  // add wgt core
  PATH_WGT.'js_src/wgt/wgt.request.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_ajax.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_conf.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_del.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_mainwin.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_page_size.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_page.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_win.js',
  PATH_WGT.'js_src/wgt/request/wgt.request.req_search.js',

  PATH_WGT.'js_src/wgt/request/ui/Callendar.js',
  PATH_WGT.'js_src/wgt/request/ui/Info.js',
  PATH_WGT.'js_src/wgt/request/ui/LinkInfo.js',
  PATH_WGT.'js_src/wgt/request/ui/MenuTable.js',
  PATH_WGT.'js_src/wgt/request/ui/Progress.js',
  PATH_WGT.'js_src/wgt/request/ui/Tab.js',
  PATH_WGT.'js_src/wgt/request/ui/Tooltip.js',
  PATH_WGT.'js_src/wgt/request/ui/Accordion.js',
  PATH_WGT.'js_src/wgt/request/ui/Dropmenu.js',
  PATH_WGT.'js_src/wgt/request/ui/Tree.js',
  PATH_WGT.'js_src/wgt/request/ui/Treetable.js',
  PATH_WGT.'js_src/wgt/request/ui/Date.js',
  PATH_WGT.'js_src/wgt/request/ui/Month.js',
  PATH_WGT.'js_src/wgt/request/ui/Wysiwyg.js',

  PATH_WGT.'js_src/wgt/wgt.desktop.js',

  // add ui
  PATH_WGT.'js_src/wgt/wgt.ui.js',
  PATH_WGT.'js_src/wgt/ui/wgt.ui.activInput.js',
  PATH_WGT.'js_src/wgt/ui/wgt.ui.table.js',
  PATH_WGT.'js_src/wgt/ui/wgt.ui.tab.js',

  // add init components
  PATH_WGT.'js_src/wgt/wgt/wgt.wgt.ini_request.js',
  PATH_WGT.'js_src/wgt/wgt/wgt.wgt.ini_windowtabs.js',

);
