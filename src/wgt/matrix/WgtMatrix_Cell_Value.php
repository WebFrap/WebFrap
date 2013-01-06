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

  public $openUrl = null;

  public $keyField = null;

  public $labelField = null;

  /**
   * @param array $data
   */
  public function render( $dataList )
  {

    $html = '';

    foreach( $dataList as $node )
    {
      $html .= ' <a class="wcm wcm_req_ajax" href="'.$this->openUrl.$node[$this->keyField].'" >'.$node[$this->labelField].'</a> ';
    }

    return $html;

  }//end public function render */

}//end class WgtMatrix_Cell_Id

