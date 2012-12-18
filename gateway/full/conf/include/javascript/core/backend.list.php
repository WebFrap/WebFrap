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

  PATH_WGT.'js_src/vendor/jquery/jquery.js',
  PATH_WGT.'js_src/ext/ext.jquery.js',

  PATH_WGT.'js_src/Wgt.js',

  // add i18n data
  PATH_WGT.'js_src/wgt/I18n.js',
  PATH_WGT.'js_src/i18n/i18n.de.js',

  // add thirdparty jquery plugins
  //PATH_WGT.'js_src/vendor/jquery.sizes/jquery.sizes.js',
  PATH_WGT.'js_src/vendor/jquery.toaster/jquery.toaster.js',
  PATH_WGT.'js_src/vendor/jquery.dropmenu/jquery.dropmenu.js',
  PATH_WGT.'js_src/vendor/jquery.tooltip/jquery.tooltip.js',
  PATH_WGT.'js_src/vendor/jquery.monthpicker/jquery.monthpicker.js',
  PATH_WGT.'js_src/vendor/jquery.treetable/jquery.treeTable.js',
  PATH_WGT.'js_src/vendor/jquery.appear/jquery.appear.js',
  PATH_WGT.'js_src/vendor/jquery.treeview/jquery.treeview.js',
  PATH_WGT.'js_src/vendor/jquery.timepicker/jquery.timepicker.js',

  // add jquery ui components
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.core.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.widget.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.mouse.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.draggable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.droppable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.resizable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.position.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.button.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.dialog.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.progressbar.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.datepicker.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.accordion.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.autocomplete.js',
  //PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.menu.js',

  // add wgt jquery plugins
  PATH_WGT.'js_src/wgt/jquery/Menuselector.js',
  PATH_WGT.'js_src/wgt/jquery/Ajaxfileupload.js',

  // add wgt core
  PATH_WGT.'js_src/wgt/jquery/ui/WgtTip.js',

  // add windows
  PATH_WGT.'js_src/wgt/Window.js',
  PATH_WGT.'js_src/wgt/window/Bookmark.js',

  // add wgt core
  PATH_WGT.'js_src/wgt/Request.js',

  PATH_WGT.'js_src/wgt/request/Handler.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerWindow.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerTab.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerArea.js',

  PATH_WGT.'js_src/wgt/wcm/action/Ajax.js',
  PATH_WGT.'js_src/wgt/wcm/action/Conf.js',
  PATH_WGT.'js_src/wgt/wcm/action/Del.js',
  PATH_WGT.'js_src/wgt/wcm/action/Mainwin.js',
  PATH_WGT.'js_src/wgt/wcm/action/PageSize.js',
  PATH_WGT.'js_src/wgt/wcm/action/Page.js',
  PATH_WGT.'js_src/wgt/wcm/action/Mtab.js',
  PATH_WGT.'js_src/wgt/wcm/action/Win.js',
  PATH_WGT.'js_src/wgt/wcm/action/Search.js',
  PATH_WGT.'js_src/wgt/wcm/action/Appear.js',

  PATH_WGT.'js_src/wgt/wcm/ui/Autocomplete.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Accordion.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Button.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Buttonset.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Calendar.js',
  PATH_WGT.'js_src/wgt/wcm/ui/ColorCode.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Console.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Date.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Dialog.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Dropmenu.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Footer.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Grid.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Highlight.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Info.js',
  PATH_WGT.'js_src/wgt/wcm/ui/LinkInfo.js',
  PATH_WGT.'js_src/wgt/wcm/ui/MenuTable.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Month.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Progress.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Tab.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Table.js',
  PATH_WGT.'js_src/wgt/wcm/ui/TreeTable.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Tree.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Tooltip.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Wysiwyg.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Timepicker.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Tip.js',
  PATH_WGT.'js_src/wgt/wcm/ui/Dropform.js',

  PATH_WGT.'js_src/wgt/wcm/chart/Area.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Pie.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Hbar.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Bar.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Rgraph.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Hypertree.js',
  PATH_WGT.'js_src/wgt/wcm/chart/Spacetree.js',

  PATH_WGT.'js_src/wgt/Desktop.js',
  PATH_WGT.'js_src/wgt/desktop/Message.js',
  PATH_WGT.'js_src/wgt/desktop/Workarea.js',

  // add ui
  PATH_WGT.'js_src/wgt/Ui.js',
  PATH_WGT.'js_src/wgt/ui/ActivInput.js',
  PATH_WGT.'js_src/wgt/ui/Table.js',
  PATH_WGT.'js_src/wgt/ui/Tab.js',
  PATH_WGT.'js_src/wgt/ui/Form.js',
  PATH_WGT.'js_src/wgt/ui/Graph.js',
  PATH_WGT.'js_src/wgt/ui/Footer.js',
  PATH_WGT.'js_src/wgt/ui/Calendar.js',

  // mini Menu
  PATH_WGT.'js_src/wgt/jquery/MiniMenu.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/ActivInput.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Callback.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Checklist.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/ColorPicker.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/DivColor.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Html.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/ListItem.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Reload.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Sep.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Sortbox.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Url.js',

  // vendor libraries
  //PATH_WGT.'js_src/vendor/jit/jit.js',
  //PATH_WGT.'js_src/vendor/excanvas/excanvas.js',

  // add init components
  PATH_WGT.'js_src/wgt/wgt/init/Request.js',
  PATH_WGT.'js_src/wgt/wgt/init/Windowtabs.js',

);

