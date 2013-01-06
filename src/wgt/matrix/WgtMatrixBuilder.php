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
 * A Menu that looks like a filesystem folder
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtMatrixBuilder
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * key feld für die X Achse
   * @var string
   */
  public $fAxisX = null;

  /**
   * Key feld für die y Achse
   * @var string
   */
  public $fAxisY = null;

  /**
   * Label für die X Achse
   * @var string
   */
  public $lAxisX = null;

  /**
   * Label für die Y Achse
   * @var string
   */
  public $lAxisY = null;

  /**
   * @var LibSq
   */
  public $data   = null;

  /**
   * Render Objekt für die Cell
   * @var WgtMatrix_Cell
   */
  public $cellRenderer  = null;

  protected $matrixData  = null;

  protected $axisX  = array( '---' => '---' );

  protected $axisY  = array( '---' => '---' );

  /**
   *
   */
  public function sortData()
  {

    foreach( $this->data as $value )
    {

      $valX = $value[$this->fAxisX];
      if( empty($valX) )
        $valX = '---';

      $valY = $value[$this->fAxisY];
      if( empty($valY) )
        $valY = '---';

      $this->axisX[$valX] = $valX;
      $this->axisY[$valY] = $valY;

      if( !isset($this->matrixData[$valX][$valY]) )
        $this->matrixData[$valX][$valY] = array();

      $this->matrixData[$valX][$valY][] = $value;
    }

  }//end public function sortData */

  /**
   *
   * @return string
   */
  public function build( )
  {

    asort( $this->axisX );
    asort( $this->axisY );

    $mHead = '';
    foreach( $this->axisY as $kY )
    {
      $mHead .= '<th>'.$kY.'</th>';
    }

    $mBody = '';
    foreach( $this->axisX as $kX  )
    {
      $mBody .= '<tr>';
      foreach( $this->axisY as $kY )
      {
        if( isset( $this->matrixData[$kX][$kY] ) )
        {
          $mBody .= '<td>'.$this->cellRenderer->render( $this->matrixData[$kX][$kY] ).'</td>';
        }
        else
        {
          $mBody .= '<td> </td>';
        }
      }
      $mBody .= '</tr>';
    }

    $html = <<<HTML
	<table class="wgt-matrix" >
		<thead>
			<tr>
{$mHead}
			</tr>
		</thead>
		<tbody>
{$mBody}
		</tbody>
	</table>
HTML;


    return $html;

  }//end public function build */


} // end class WgtMatrix


