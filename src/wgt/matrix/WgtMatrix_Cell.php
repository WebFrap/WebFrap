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

  /**
   * Type der Cell
   * @var string
   */
  public $type = '';

  /**
   * Env object
   * @var Base
   */
  public $env = null;

  /**
   * @param array $data
   */
  public function render( $data )
  {

  }//end public function render */

}//end class WgtMatrix_Cell
