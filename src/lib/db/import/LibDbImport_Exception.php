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
 * class LibDb_Exception
 * the database exception, this exception always will be thrown on database errors
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDbImport_Exception extends LibDb_Exception
{

  /**
   * @param string $message
   */
  public function __construct($message = null)
  {

    $this->delete = true;

    if (!$message)
      $message = 'just forget the dataset';

    parent::__construct($message);

  }//end public function __construct */

}//end class LibDbImportForget_Exception

