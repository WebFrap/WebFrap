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
class WgtSelectboxWebfrapSupportedDbms
  extends WgtSelectboxHardcoded
{

  /**
   * first free string
   *
   * @var string
   */
  public $firstFree = 'select your dbms';

  /**
   * the data array
   *
   * @var array
   */
  protected $data = array
  (
  'pgsql'     =>  array( 'value' => 'PostgreSQL'   ),
  'pdo_pgsql' =>  array( 'value' => 'PDO PostgreSQL'   ),
  'mysqli'    =>  array( 'value' => 'MySQL(i)'   ),
  'pdo_mysql' =>  array( 'value' => 'PDO MySQL'  ),
  );

} // end class WgtSelectboxWebfrapSupportedDbms
