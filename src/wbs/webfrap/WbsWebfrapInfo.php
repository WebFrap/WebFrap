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
 * Webservice WebFrap Info
 * table for the tags
 * @package WebFrap
 * @subpackage tech_core
 * @author admin admin
 * @copyright admin admin
 */
class WbsWebfrapInfo
  extends Webservice
{
////////////////////////////////////////////////////////////////////////////////
// Load Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * load
   * @return void
   */
  public function loadVersion()
  {
    $this->data['version'] = Conf::status('sys.version');

  }//end public function loadVersion */

  /**
   * load
   * @return void
   */
  public function loadGenerator()
  {
    $this->data['generator'] = Conf::status('sys.generator');

  }//end public function loadGenerator */

  /**
   * load
   * @return void
   */
  public function loadLicence()
  {

    $this->data['licence'] = Conf::status('sys.licence');

  }//end public function loadLicence */

}//end class WbsWebfrapInfo
