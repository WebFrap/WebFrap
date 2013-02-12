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
 * Die Exception die durch die Gegend fliegt wenn Sicherheitsprobleme fest
 * gestell werden
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Security_Exception
  extends Webfrap_Exception
{

  /**
   * de:
   * Standard Code ist forbidden
   * @var int
   */
  public $code = Response::FORBIDDEN;

}
