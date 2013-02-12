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
class WgtMatrix_Cell_Value
 extends WgtMatrix_Cell
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $openUrl = null;

  /**
   * @var string
   */
  public $keyField = null;

  /**
   * @var string
   */
  public $labelField = null;

  /**
	 * Type des cell values
   * @var string
   */
  public $type = 'short';

////////////////////////////////////////////////////////////////////////////////
// Method
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param array $data
   */
  public function render( $dataList )
  {

    $html = array();

    foreach( $dataList as $node )
    {
      $html[] = '<a class="wcm wcm_req_ajax" href="'.$this->openUrl.$node[$this->keyField].'" >'.$node[$this->labelField].'</a>';
    }

    return implode(', ', $html);

  }//end public function render */

}//end class WgtMatrix_Cell_Id

