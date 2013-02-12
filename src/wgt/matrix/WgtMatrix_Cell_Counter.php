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
class WgtMatrix_Cell_Counter
 extends WgtMatrix_Cell
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
     * Type des cell values
   * @var string
   */
  public $type = 'counter';

  /**
   * @param array $data
   */
  public function render( $data )
  {
    return count( $data ).' Items';
  }//end public function render */

}//end class WgtMatrix_Cell_Counter
