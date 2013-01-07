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
   * die HTML ID für das Matrix element
   * @var string
   */
  public $idKey = null;

  /**
   * die HTML ID für das Matrix element
   * @var string
   */
  public $id = null;

  /**
   * die HTML ID des Formulars welche für die Suche verwendet wird
   * Wenn vorhanden wird kein eingenes Search form mit gebaut, sondern ein
   * externen Search form verwendet
   * @var string
   */
  public $searchFormID = null;

  /**
   * Url für die Suche in der Matrix
   * Wird nicht benötigt wenn bereits eine searchFormID gesetzt wurde
   * @var string
   */
  public $searchURL = null;

  /**
   * URL zum hinzufügen neuer Einträge in die Matrix
   * @var string
   */
  public $addURL = null;

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
   * Panel Renderer
   * @var WgtPanel
   */
  public $panel  = null;

  /**
   * Type des listing elements
   * @var string
   */
  public $type = 'matrix';

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
// Constructor
////////////////////////////////////////////////////////////////////////////////


  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $env )
  {

    $this->env = $env;

  } // end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Method
////////////////////////////////////////////////////////////////////////////////

  /**
   * Sortieren der Query daten in ein Matrixformat
   * Sicher gehen, dass alle Felder belegt sind
   */
  public function prepareData()
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

    if( $this->idKey )
      $this->id = 'wgt-matrix-'.$this->idKey;
    else
      $this->idKey = substr($this->id, 11);

  }//end public function prepareData */

  /**
   * Rendern der Matrix
   * @return string
   */
  public function render( $params = null )
  {

    $this->prepareData();

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

      $selected = '';
      if( $key == $this->cellRenderer->type )
        $selected = ' selected="selected" ';

      $codeVariants .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $codeGroupsRow = '';
    foreach( $this->groupList as $key => $label )
    {
      $selected = '';
      if( $key == $this->fAxisX )
        $selected = ' selected="selected" ';

      $codeGroupsRow .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $codeGroupsCol = '';
    foreach( $this->groupList as $key => $label )
    {
      $selected = '';
      if( $key == $this->fAxisY )
        $selected = ' selected="selected" ';

      $codeGroupsCol .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $panel = $this->renderPanel();


    $searchForm = '';
    if( $this->searchURL )
    {

      $this->searchFormID = 'wgt-search-matrix-'.$this->idKey;

      $searchForm = <<<HTML

  <form
  	id="{$this->searchFormID}"
  	method="get"
  	action="{$this->searchURL}&amp;element={$this->id}" ></form>

HTML;

    }

    $view = $this->env;

    $iconAdd = $view->icon( 'control/add.png', 'Create' );
    $iconRefresh = $view->icon( 'control/refresh.png', 'Refresh' );

    $html = <<<HTML
<div id="{$this->id}-box" >

  {$panel}
  {$searchForm}

  <div class="wgt-panel" >
  	<button class="wgt-button" onclick="\$R.get('{$this->addURL}');" >{$iconAdd} Create</button>
		&nbsp;|&nbsp;&nbsp;
		<label>Rows:</label> <select
			name="grow"
			class="fparam-{$this->searchFormID} medium"
			  >{$codeGroupsRow}</select>&nbsp;|&nbsp;
		<label>Cols:</label> <select
			name="gcol"
			class="fparam-{$this->searchFormID} medium"
				>{$codeGroupsCol}</select>&nbsp;|&nbsp;
		<label>Show as:</label> <select
			name="vari"
			class="fparam-{$this->searchFormID} medium"
				>{$codeVariants}</select>
		&nbsp;&nbsp; <button class="wgt-button" onclick="\$R.form('{$this->searchFormID}');"  >{$iconRefresh} Refresh</button>
  </div>

	<table class="wgt-matrix" id="{$this->id}" >
		<thead>
			<tr>
{$mHead}
			</tr>
		</thead>
		<tbody>
{$mBody}
		</tbody>
	</table>

</div>
HTML;


    return $html;

  }//end public function render */


  /**
   * @return string
   */
  protected function renderPanel()
  {

    if( !$this->panel )
      return '';

    return $this->panel->build();

  }//end protected function renderPanel */

} // end class WgtMatrix


