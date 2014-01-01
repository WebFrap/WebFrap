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
class LibDbImportDrop_Exception extends Exception
{

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $resource = null;

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $key = null;

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $delete = false;

  /**
   * @param unknown_type $message
   * @param unknown_type $resource
   * @param unknown_type $key
   * @param unknown_type $delete
   */
  public function __construct($message, $resource, $key, $delete = false)
  {

    $this->resource = $resource;

    $this->key = $key;

    $this->delete = $delete;

    parent::__construct($message);
  }

}//end class LibDbImportDrop_Exception

