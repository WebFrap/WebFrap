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
 * @lang de:
 *
 *
 * @package WebFrap
 * @subpackage wgt
 */
abstract class WgtMatrix_Cell
{

  public $type = '';

  /**
   * Env object
   * @var Base
   */
  public $env = null;

  public function render( $data )
  {

  }

}//end class WgtMatrix_Cell

