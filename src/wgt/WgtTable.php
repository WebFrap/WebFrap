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
 * @package WebFrap
 * @subpackage wgt
 */
class WgtTable extends WgtList
{

  /*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $icon = null;

  /**
   *
   * @var store the meta informations for the table
   */
  protected $metaInfo = '';

  /**
   *
   * @var string
   */
  protected $searchUrl = null;

  /**
   * flag if this table is editable
   * @var boolean
   */
  public $editAble = false;

  /**
   * show multiselect row in the table
   * @var boolean
   */
  public $enableMultiSelect = false;

  /**
   * die höhe des bodies
   * @var string
   */
  public $bodyHeight = null;

  /**
   * char flag, for a filter on a first char in a col
   * @var string
   */
  public $begin = null;

  /**
   * the title of the table
   * @var string
   */
  public $title = null;

  /**
   * Setzen eines Namespaces
   * @var string
   */
  public $namespace = null;

  /**
   * Key zum errechnen des korrekten Search Formulars
   * @var string
   */
  public $searchKey = null;

  /**
   * is there a advanced search
   * @var boolean
   */
  public $advancedSearch = false;

  /**
   * the title of the table
   * @var string
   */
  public $type = 'table';

  /*//////////////////////////////////////////////////////////////////////////////
// Magic methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   * @param LibTemplate $view
   */
  public function __construct ($name = null, $view = null)
  {

    $this->name = $name;
    $this->stepSize = Wgt::$defListSize;

    // when a view is given we asume that the element should be injected
    // directly to the view
    if ($view) {
      $this->view = $view;
      $this->i18n = $view->getI18n();

      if ($view->access)
        $this->access = $view->access;

      if ($name)
        $view->addElement($name, $this);
    } else {
      $this->i18n = Webfrap::$env->getI18n();
    }

    $this->loadUrl();

    if (DEBUG)
      Debug::console("new element " . get_class($this));

  } //end public function __construct */

  /*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $icon
   */
  public function setIcon ($icon)
  {

    $this->icon = $icon;
  } //end public function setIcon */

  /**
   * @param string $title
   */
  public function setTitle ($title)
  {

    $this->title = $title;
  } //end public function setTitle */

  /**
   * @param string $key
   */
  public function setSearchKey ($key)
  {

    $this->searchKey = $key;
  } //end public function setSearchKey */

  /**
   * @param string $namespace
   */
  public function setNamespace ($namespace)
  {

    $this->namespace = $namespace;
  } //end public function setNamespace */

  /*//////////////////////////////////////////////////////////////////////////////
// Table Navigation
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the table
   *
   * @return string
   */
  public function build ()
  {

    if (! $this->html)
      $this->html = '<p>empty</p>';

    return $this->html;

  } //end public function build */

  /**
   * @return string
   */
  public function menuNumEntries ()
  {

    ///@todo extend this
    //wcm wcm_req_page '.$this->searchForm
    // $S(\'form#'.$this->searchForm.'\').data(\'size\',$S(this).val());


    //$onchange = 'onchange="$S(\'form#'.$this->searchForm.'\').data(\'qsize\',$S(this).val());$R.form(\''.$this->searchForm.'\');"';
    $onchange = 'onchange="$S(\'table#' . $this->id . '-table\').grid( \'pageSize\', \'' . $this->searchForm . '\',this)"';

    if (! $sizes = Conf::status('ui.listing.numEntries'))
      $sizes = array(
        10, 25, 50, 100, 250, 500
      );

    $menu = '<select class="wgt-no-save small" ' . $onchange . ' >';

    foreach ($sizes as $size) {
      $selected = ($size == $this->stepSize) ? 'selected="selected"' : '';
      $menu .= '<option value="' . $size . '" ' . $selected . ' >' . $size . '</option>';
    }

    $menu .= '</select>';

    return $menu;

  } //end public function menuNumEntries */


  /**
   * @return string
   */
  public function menuTableSize ()
  {

    ///@todo extend this
    return '<input class="fparam-' . $this->searchForm . ' valid-number" name="offset" type="text" value="0" style="width:40px;" />&nbsp;&nbsp;' . '<span> / <strong class="wgt-num-entry" >' . $this->dataSize . '</strong> ' . $this->i18n->l('Entries', 'wbf.label') . '</span>';

  } //end public function menuNumEntries */


  /**
   * @return string
   */
  public function menuCharFilter ()
  {

    $class = 'wcm wcm_req_page ' . $this->searchForm . '';

    $html = '<span class="wgt_char_filter" >';
    $html .= '<a class="' . $class . '" href="c=?" > ? </a> | ';

    $charVal = 65;

    while ($charVal < 91) {
      $aktiv = '';

      $char = chr($charVal);

      if ($this->begin == $char)
        $aktiv = ' ui-state-active';

      $html .= '<a class="' . $class . $aktiv . '" href="b=' . $char . '" > ' . $char . ' </a> | ';
      ++ $charVal;
    }

    $html .= '<a class="' . $class . '" href="b=" ><i class="icon-minus-sign" ></i></a>';
    $html .= '</span>';

    return $html;

  } //end public function menuCharFilter */


  /**
   *
   */
  public function tableFootLeft ()
  {

  } //end public function tableFootLeft */




  /**
   *
   */
  public function tableSubFootRight ()
  {
    return $this->menuNumEntries();

  } //end public function tableFootLeft */


  /**
   *
   */
  public function tableSubFootLeft ()
  {
    return $this->menuTableSize();

  } //end public function tableFootLeft */


  /**
   * @return string
   */
  public function tableFootRight ()
  {
    return '';

  } //end public function tableFootRight */


  /**
   * @return string
   */
  public function buildTableFooter ()
  {

    $html = ' <div class="wgt-panel wgt-border-top" >';
    $html .= '  <div class="right menu"  >';
    $html .= $this->menuTableSize();
    $html .= '  </div>';
    $html .= '  <div class="menu"  style="text-align:center;margin:0px auto;" >';
    $html .= $this->menuCharFilter();
    $html .= '  </div>';
    $html .= $this->metaInformations();
    $html .= '</div>' . NL;

    return $html;

  } //end public function buildTableFooter */


  /**
   * @return string
   */
  public function metaInformations ()
  {
    return $this->metaInfo;
  } //end public function metaInformations */


  /**
   * build the table
   *
   * @return string
   */
  public function buildHtml ()
  {

    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if ($this->html)
      return $this->html;

   // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '<div id="' . $this->id . '" class="wgt-border" >' . NL;
      $this->html .= $this->buildPanel();

      $classes = implode(' ', $this->classes);

      $this->html .= '<table id="' . $this->id . '-table" class="wgt-table ' . $classes . '" >' . NL;
      $this->html .= $this->buildThead();
    }

    $this->html .= $this->buildTbody();

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
      $this->html .= '</table>';
      $this->html .= $this->buildTableFooter();
      $this->html .= '</div>' . NL;

      $this->html .= '<script type="application/javascript" >' . NL;
      $this->html .= $this->buildJavascript();
      $this->html .= '</script>' . NL;
    }

    return $this->html;

  } //end public function buildHtml */


  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea ()
  {

    $this->refresh = true;

    if ($this->xml)
      return $this->xml;

    if ($this->appendMode) {

      $html = '<!-- buildAjaxArea --><htmlArea selector="#' . $this->id . '-table>tbody" action="append" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>' . NL;

    } else {

      $html = '<!-- buildAjaxArea --><htmlArea selector="#' . $this->id . '-table>tbody" action="replace" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>' . NL;

    }

    $this->xml = $html;

    return $html;

  } //end public function buildAjaxArea */


  /**
   * @return string
   */
  public function buildPanel ()
  {

    if (! $this->panel)
      return '';

    return $this->panel->build();

  } //end public function buildPanel */


  /**
   * build the table
   *
   * @return string
   */
  public function buildCli ()
  {

    // if we have html we can assume that the table was allready assembled
    // so we return just the html and stop here
    // this behaviour enables you to call a specific buildr method from outside
    // of the view, but then get the html of the called build method
    if ($this->html)
      return $this->html;

    $line = "--------------------------------------------------------------------------------" . NL;

    $this->html = $line;

    if (! $this->data) {
      $this->html = '| No data ';
    }

    return $this->html;

  } //end public function buildCli */

}//end class WgtTable

