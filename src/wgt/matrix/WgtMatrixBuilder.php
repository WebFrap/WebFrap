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
class WgtMatrixBuilder extends WgtList
{
/*//////////////////////////////////////////////////////////////////////////////
// logic
//////////////////////////////////////////////////////////////////////////////*/

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
   * Url für die Suche in der Matrix
   * Wird nicht benötigt wenn bereits eine searchForm gesetzt wurde
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
   * @var string
   */
  public $accessPath = null;

  /**
   * @var array
   */
  public $actions = array();

  /**
   * Namekey
   * @var string
   */
  public $nKey = null;

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

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name, $view )
  {

    $this->env = $view;

    $view->addItem($name,  $this );

    $this->idKey = $name;

  } // end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $cellType
   */
  public function setCellRenderer($cellType )
  {

    if (!$cellType )
      $cellType = 'Tile';

    $cellClass = $this->nKey.'_Matrix_Cell_'.ucfirst($cellType);

    $this->cellRenderer = new $cellClass($this );

  }//end public function setCellRenderer */

  /**
   * Sortieren der Query daten in ein Matrixformat
   * Sicher gehen, dass alle Felder belegt sind
   */
  public function prepareData()
  {

    Debug::console( "IN prepare data ".count($this->data) );

    foreach ($this->data as $value) {

      $valX = $value[$this->lAxisX];
      if ( empty($valX) )
        $valX = '---';

      $valY = $value[$this->lAxisY];
      if ( empty($valY) )
        $valY = '---';

      $this->axisX[$valX] = $valX;
      $this->axisY[$valY] = $valY;

      if (!isset($this->matrixData[$valY][$valX]) )
        $this->matrixData[$valY][$valX] = array();

      $this->matrixData[$valY][$valX][] = $value;
    }

    if ($this->idKey )
      $this->id = 'wgt-matrix-'.$this->idKey;
    else
      $this->idKey = substr($this->id, 11);

  }//end public function prepareData */

  /**
   * Rendern der Matrix
   * @return string
   */
  public function render($params = null )
  {

    if ($this->html )
      return $this->html;

    $this->prepareData();

    asort($this->axisX );
    asort($this->axisY );

    $mHead = '<th></th>';
    foreach ($this->axisY as $kY) {
      $mHead .= '<th>'.$kY.'</th>';
    }

    $mBody = '';
    foreach ($this->axisX as $kX) {
      $mBody .= '<tr>';
      $mBody .= '<td class="head" >'.$kX.'</td>';
      foreach ($this->axisY as $kY) {
        if ( isset($this->matrixData[$kY][$kX] ) ) {
          $mBody .= '<td>'.$this->cellRenderer->render($this->matrixData[$kY][$kX] ).'</td>';
        } else {
          $mBody .= '<td> </td>';
        }
      }
      $mBody .= '</tr>';
    }

    $codeVariants = '';
    foreach ($this->variantList as $key => $label) {

      $selected = '';
      if ($key == $this->cellRenderer->type )
        $selected = ' selected="selected" ';

      $codeVariants .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $codeGroupsRow = '';
    foreach ($this->groupList as $key => $label) {
      $selected = '';
      if ($key == $this->fAxisX )
        $selected = ' selected="selected" ';

      $codeGroupsRow .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $codeGroupsCol = '';
    foreach ($this->groupList as $key => $label) {
      $selected = '';
      if ($key == $this->fAxisY )
        $selected = ' selected="selected" ';

      $codeGroupsCol .= '<option value="'.$key.'" '.$selected.'  >'.$label.'</option>';
    }

    $panel = $this->renderPanel();

    $searchForm = '';
    if ($this->searchURL) {

      $this->searchForm = 'wgt-search-matrix-'.$this->idKey;

      $searchForm = <<<HTML

  <form
    id="{$this->searchForm}"
    method="get"
    action="{$this->searchURL}&amp;element={$this->id}" ></form>

HTML;

    }

    //$view = $this->env->getView();

    /*

    <button class="wgt-button" onclick="\$R.get('{$this->addURL}');" >{$iconAdd} Create</button>
    &nbsp;|&nbsp;&nbsp;
     */

    $html = <<<HTML
<div class="wgt-grid" id="{$this->id}-box" >

<var id="{$this->id}-table-cfg-grid" >{
  "height":"{$this->bodyHeight}",
  "search_able":true,
  "search_form":"{$this->searchForm}",
  "select_able":"true"
}</var>

  {$panel}
  {$searchForm}

  <div class="wgt-panel" >
    <label>Rows:</label> <select
      name="grow"
      class="fparam-{$this->searchForm} medium"
        >{$codeGroupsRow}</select>&nbsp;|&nbsp;
    <label>Cols:</label> <select
      name="gcol"
      class="fparam-{$this->searchForm} medium"
        >{$codeGroupsCol}</select>&nbsp;|&nbsp;
    <label>Show as:</label> <select
      name="vari"
      class="fparam-{$this->searchForm} medium"
        >{$codeVariants}</select>
    &nbsp;&nbsp; <button class="wgt-button" onclick="\$R.form('{$this->searchForm}');"  ><i class="icon-refresh" ></i> Refresh</button>
  </div>

  <table class="wgt-grid wcm wcm_widget_grid hide-head wgt-matrix" id="{$this->id}-table"  >
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

    $this->html = $html;

    return $html;

  }//end public function render */

  public function buildHtml()
  {
    return $this->render();
  }

  /**
   * @return string
   */
  protected function renderPanel()
  {

    if (!$this->panel )
      return '';

    return $this->panel->build();

  }//end protected function renderPanel */

} // end class WgtMatrix

