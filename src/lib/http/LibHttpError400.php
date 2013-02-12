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
  *
  * @package WebFrap
  * @subpackage tech_core
  */
class LibHttpError400
{

  /**
   *
   * @param LibTemplate $view
   */
  public function publish( $view )
  {

    $view->addVar('title','404 Not Found');
    $view->addVar('code','404');
    $view->addVar
    (
      'content',
      'Hi, that what you requested not exists.'
    );

    $view->setTemplate('error/http/404');

  }//end public function publish */

} // end class LibHttpError400
