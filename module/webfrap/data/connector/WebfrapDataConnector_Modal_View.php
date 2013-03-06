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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapDataConnector_Modal_View extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see WgtModal::$width
   */
  public $width = 800;

  /**
   * @see WgtModal::$height
   */
  public $height = 600;

  /**
   * @param Context $params
   * @return void
   */
  public function displayForm()
  {

    $this->setStatus('Data Connector');
    $this->setTitle('Data Connector');

    $this->setTemplate( 'webfrap/data/connector/modal/form', true );

  }//end public function displayForm */

}//end class WebfrapDataConnector_Modal_View

