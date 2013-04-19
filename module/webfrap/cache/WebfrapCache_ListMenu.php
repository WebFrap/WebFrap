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

/**
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapCache_ListMenu
{

  /**
   * @param array $cDir
   */
  public function renderDisplay($cDir)
  {

    $code = array();

    if (isset($cDir->display)) {
      foreach ($cDir->display as $action) {
        switch ($action) {
          case 'created':
          {
            $code[] = "Updated: ".SFilesystem::timeChanged(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'size':
          {
            $code[] = "Size: ".SFilesystem::getFolderSize(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'num_files':
          {
            $code[] = "Files: ".SFilesystem::countFiles(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
        }
      }
    }

    return implode('<br />', $code);
  }

  /**
   * @param array $cDir
   */
  public function renderActions($cDir)
  {

    $code = array();

    if (isset($cDir->actions)) {
      foreach ($cDir->actions as $action) {
        switch ($action->type) {
          case 'request':
          {
            $code[] = <<<CODE

<button
  class="wgt-button"
  onclick="\$R.{$action->method}('{$action->service}');" >{$action->label}</button>

CODE;
            break;
          }
        }
      }
    }

    return implode('<br />', $code);

  }//end public renderActions */

}//end class WebfrapCache_ListMenu

