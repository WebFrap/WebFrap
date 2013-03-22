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
class WebfrapBookmark_Model extends Model
{

  /**
   * @param LibTemplate $view
   * @return void
   */
  public function desktop($view  )
  {

    $db = $this->getDb();

    $query = $db->newQuery('WebfrapBookmark');
    $query->fetch($this->getUser()->getId());

    $table = $view->newItem('widgetDesktopBookmark' , 'TableWebfrapBookmark');
    $table->setData($query);
    $table->setId('wbf_desktop_bookmark');

  }//end public function desktop */

} // end class WebfrapBookmark_Model

