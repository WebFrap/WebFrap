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
 * Abstract Class For SysExtention Controllers
 *
 * @package WebFrap
 * @subpackage tech_core
 */
interface ITransaction
{

////////////////////////////////////////////////////////////////////////////////
// Interface Logic Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * start a transaction
   * @return void
   */
  public function begin();

  /**
   * sucessfully end a transaction
   *
   */
  public function commit();

  /**
   * rollback if a transaction fails
   *
   */
  public function rollback();

}// end interface ITransaction
