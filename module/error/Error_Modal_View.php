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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Error_Modal_View extends WgtModal
{

  /**
   *
   */
  public function displayException( $exception )
  {

    $this->setTemplate('error/display_exception');

    $this->addVar( 'exception', $exception );

  }//end public function displayException */

  /**
   *
   */
  public function displayEnduserError( $exception )
  {

    $this->setTemplate('error/display_exception');

    $this->addVar( 'exception', $exception );

  }//end public function displayEnduserError */

} // end class Error_Subwindow_View

