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
   * Der Title für die Matrix
   * @var string
   */
  public $title = null;

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
   * Liste der Felder welche zum sortieren verwendet werden können
   * @var array
   */
  public $groupList = array();

  /**
   * Varianten
   * @var array
   */
  public $variantList = array
  (
  );

  /**
   * @var LibSq
   */
  public $data   = null;

  /**
   * Render Objekt für die Cell
   * @var WgtMatrix_Cell
   */
  public $cellRenderer  = null;

  /**
   * Die Datenmatrix
   * @var array
   */
  protected $matrixData  = null;

  /**
   * X Achse mit platzhalter für leere werte
   * @var array
   */
  protected $axisX  = array( '---' => '---' );

  /**
   * Y Achse mit platzhalter für leere werte
   * @var array
   */
  protected $axisY  = array( '---' => '---' );

////////////////////////////////////////////////////////////////////////////////
// Method
////////////////////////////////////////////////////////////////////////////////

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

    $this->sortData();

    asort( $this->axisX );
    asort( $this->axisY );

    $mHead = '<th></th>';
    foreach( $this->axisY as $kY )
    {
      $mHead .= '<th>'.$kY.'</th>';
    }

    $mBody = '';
    foreach( $this->axisX as $kX  )
    {
      $mBody .= '<tr>';
      $mBody .= '<td class="head" >'.$kX.'</td>';
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

    $codeVariants = '';
    foreach( $this->variantList as $key => $label )
    {
      $codeVariants .= '<option value="'.$key.'" >'.$label.'</option>';
    }

    $codeGroups = '';
    foreach( $this->groupList as $key => $label )
    {
      $codeGroups .= '<option value="'.$key.'" >'.$label.'</option>';
    }

    $html = <<<HTML

  <div class="wgt-panel title" >
		<h2>{$this->title}</h2>
  </div>

  <div class="wgt-panel" >
		<label>Rows:</label> <select class="medium" >{$codeGroups}</select>&nbsp;|&nbsp;
		<label>Cols:</label> <select class="medium" >{$codeGroups}</select>&nbsp;|&nbsp;
		<label>Show as:</label> <select class="medium" >{$codeVariants}</select>
		&nbsp;&nbsp; <button class="wgt-button" >Refresh</button>
  </div>

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


