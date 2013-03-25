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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WebfrapSetup_Html_View extends LibTemplatePlain
{

  /**
   *
   */
  public function displayStart($params)
  {
    $this->setIndex('setup');
    $this->setTemplate('webfrap/setup/maintab/start');
  }//end public function displayStart */

} // end class WebfrapSetup_Html_View

