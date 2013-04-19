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
 * @subpackage tech_core
 */
abstract class LibParserCrumbmenuAbstract
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var Logsys
   */
  protected $log = null;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $data = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct($data)
  {
    $this->data = $data;

  }//end public function __construct

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();

  }//end public function __toString

/*//////////////////////////////////////////////////////////////////////////////
// Parser
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  abstract public function build();

} // end class ObjParserCrumbmenuAbstract

