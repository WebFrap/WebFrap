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
 *
 * @author sono
 *
 */
abstract class WgtTree extends WgtAbstract
{

  public $type = 'tree';

/*//////////////////////////////////////////////////////////////////////////////
// method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   * @param LibTemplate $view
   */
  public function __construct($name = null, $view = null)
  {

    $this->name     = $name;
    $this->stepSize = Wgt::$defListSize;

    // when a view is given we asume that the element should be injected
    // directly to the view
    if ($view) {
      $this->view = $view;
      $this->i18n = $view->getI18n();

      $view->addElement($name,$this);
    } else {
      $this->i18n     = I18n::getDefault();
    }

  }//end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

  /**
   * @return string
   */
  public function getId()
  {
    if (is_null($this->id))
      $this->id = 'wgt-tree-'.WebFrap::uniqid();

    return $this->id;

  }//end public function getId */

  /**
   *
   * @param $id
   * @return unknown_type
   */
  public function setId($id)
  {
    $this->id = $id;
  }//end public function setId */

  /**
   *
   * @return string
   */
  public function build()
  {

    if ($this->html)
      return $this->html;

    if (count($this->data) == 0) {
      $this->html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;
      $this->html .= '</ul>'.NL;

      return $this->html;
    }

    $html = '';

    $html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;

    foreach ($this->data as $id => $row) {

      $entry    = $this->buildTreeNode($row);

      $html .= <<<HTML
<li id="{$this->id}_{$id}" >

  {$entry}
  <ul id="{$this->id}_{$id}_tree" ></ul>

</li>

HTML;


    }

    $html .= '</ul>'.NL;


    $this->html = $html;

    return $this->html;

  }//end public function build */


  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxNode($parentNode)
  {

    if ($this->html)
      return $this->html;

    $html = '';

    if ($this->ajaxInsert) {

        $html .= <<<HTML
      <htmlArea selector="ul#{$parentNode}" action="append" ><![CDATA[
HTML;

      foreach ($this->data as $id => $row) {

        $entry  = $this->buildTreeNode($row);

        $html .= <<<HTML
      <li id="{$this->id}_{$id}" >
        {$entry}
        <ul id="{$this->id}_{$id}_tree" ></ul>
      </li>
HTML;

      }

        $html .= <<<HTML
]]></htmlArea>
HTML;


    }//end if
    else {
        $html .= <<<HTML
      <htmlArea selector="ul#{$parentNode}" action="replace" ><![CDATA[
HTML;

      foreach ($this->data as $id => $row) {

        $entry  = $this->buildTreeNode($row);

        $html .= <<<HTML
      <li id="{$this->id}_{$id}" >
        {$entry}
        <ul id="{$this->id}_{$id}_tree" ></ul>
      </li>
HTML;

      }

        $html .= <<<HTML
]]></htmlArea>
HTML;

    }//end else

    $this->html = $html;

    return $this->html;

  }//end public function buildAjaxNode */

}//end class WgtTree
