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
class Error_Node
{

  /**
   * Die genaue Fehlermeldung
   * @var string
   */
  public $errorMessage = null;

  /**
   * Der HTTP Fehlercode
   * @var int
   */
  public $errorCode = null;

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function getMessage()
  {
    return $this->errorMessage;
  }//end public function getMessage */

  /**
   * @return int
   */
  public function getCode()
  {
    return $this->errorCode;
  }//end public function getCode */

} // end class Error_Node
