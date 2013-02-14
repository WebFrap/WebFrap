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
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class WgtMenuBuilderPaging
{
  
  public $i18n;
  
  public $elementId;
  
  public $element;
  
  public function __construct( $element )
  {
    
    $this->i18n = $element->getI18n();
    $this->element = $element;
    
    $this->elementId = $element->getId();
  }

  /**
   *
   * @param string  $linkTarget
   * @param boolean $ajax
   * @return string
   */
  public function pagingMenu($linkTarget, $dataSize, $stepSize, $anzMenuNumbers, $ajax = true)
  {

    if ($dataSize <= $stepSize)
      return '';
    
    if ($ajax) {
      $baseUrl = 'p=';
    } else {
      $baseUrl = $linkTarget .= '&amp;target_id=' . $this->elementId . '&amp;start=';
    }
    
    $activPos = $this->start;
    
    // calculate the activ position
    $activPos = floor($activPos / $stepSize);
    $startPos = $activPos - floor($anzMenuNumbers / 2);
    
    // start can not be smaller than 0
    if ($startPos < 0)
      $startPos = 0;
    
    $endPos = $startPos + $anzMenuNumbers;
    
    $last = floor($dataSize / $stepSize);
    
    if ($activPos > $last)
      $activPos = $last;
    
    if ($endPos > $last)
      $endPos = $last + 1;
    
    $oneVor = $activPos + 1;
    $oneZurueck = $activPos - 1;
    
    if ($oneVor > $last)
      $oneVor = $last;
    
    if ($oneZurueck < $startPos)
      $oneZurueck = $startPos;
    
    $class = $ajax ? 'class="wcm wcm_req_page ' . $this->element->searchForm . '"' : '';
    
    $html = '<a ' . $class . ' title="' . $this->i18n->l('Back to Start', 'wbf.label') . '" href="' . $baseUrl . '0">
      <img  src="' . View::$iconsWeb . 'xsmall/webfrap/toStart.png"
            style="border:0px"
            alt="' . $this->i18n->l('Back to start', 'wbf.label') . '" />
      </a>&nbsp;&nbsp;';
    
    $html .= '<a ' . $class . ' title="' . $this->i18n->l('{@X@} Entries back', 'wbf.label', array(
      'X' => $stepSize
    )) . '" href="' . $baseUrl . ($oneZurueck * $stepSize) . '">
      <img  src="' . View::$iconsWeb . 'xsmall/webfrap/back.png"
            style="border:0px"
            alt="' . $this->i18n->l('{@X@} Entries back', 'wbf.label', array(
      'X' => $stepSize
    )) . '" />
        </a>&nbsp;&nbsp;';
    
    // add the entries in the middle
    for($nam = $startPos; $nam < $endPos; ++ $nam) {
      
      if ($ajax) {
        $urlClass = ($nam == $activPos) ? 'class="ui-state-active wcm wcm_req_page ' . $this->element->searchForm . '"' : 'class="wcm wcm_req_page ' . $this->element->searchForm . '"';
      } else {
        $urlClass = ($nam == $activPos) ? 'class="ui-state-active"' : '';
      }
      
      $title = $this->i18n->l('Show the next {@Y@} {@X@} Entires', 'wbf.label', array(
        'Y' => $nam, 'X' => $stepSize
      ));
      
      $html .= '<a ' . $urlClass . ' title="' . $title . '"
        href="' . $baseUrl . ($nam * $stepSize) . '">' . ($nam + 1) . '</a>&nbsp;&nbsp;';
      
      $urlClass = '';
    }
    
    // check if it's neccesary to show the end
    if ($last > $anzMenuNumbers) {
      $html .= '&nbsp;...&nbsp;&nbsp;';
      
      $title = $this->i18n->l('Show the Last {@X@} Entries', 'wbf.label', array(
        'X' => $stepSize
      ));
      
      $html .= '<a ' . $class . '
        title="' . $title . '"
        href="' . $baseUrl . ($last * $stepSize) . '" >' . ($last + 1) . '</a>&nbsp;&nbsp;';
    }
    
    $title = $this->i18n->l('Show the next {@X@} Entries', 'wbf.label', array(
      'X' => $stepSize
    ));
    $html .= '<a ' . $class . ' title="' . $title . '"
      href="' . $baseUrl . ($oneVor * $stepSize) . '" >
      <img  src="' . View::$iconsWeb . 'xsmall/webfrap/forward.png"
            style="border:0px"
            alt="' . $title . '" /></a>&nbsp;&nbsp;';
    
    $html .= '<a ' . $class . ' title="' . $this->i18n->l('Go to the Last Entry', 'wbf.label') . '"
      href="' . $baseUrl . ($last * $stepSize) . '" >
      <img  src="' . View::$iconsWeb . 'xsmall/webfrap/toEnd.png"
            style="border:0px"
            alt="' . $this->i18n->l('Go to the last entry', 'wbf.label') . '" /></a>';
    
    return $html;
  
  } // end public function pagingMenu */
  
  
}//end class WgtMenuBuilderPaging
