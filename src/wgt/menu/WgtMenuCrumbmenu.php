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
 * class VobNavmenu
 * Objekt zum generieren des Mainmenus eines Users
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtMenuCrumbmenu extends WgtAbstract
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string Parsername
   */
  protected $buildrName = null;

  /**
   * @var string Parsername
   */
  public $refresh = 'html';

  public $id = 'wgt_crumbmenu';


/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string/WgtMenuCrumb $text
   * @param string $url
   * @param string $title
   * @return WgtMenuEntryAbstract
   */
  public function newCrumb($text , $url = null , $class = null , $type = 'Crumb' )
  {

    if ( is_object($text) )
    {
      $entry = $text;
    } else {
      $className = 'WgtMenu'.$type;

      $entry = new $className( 'navmenuentry' );
      $entry->text = $text;
      $entry->data = $url;
      $entry->class = $class;
    }

    $this->data[] = $entry;

    return $entry;
  }//end public function addEntry

  /**
   * @return void
   */
  public function cleanEntrys()
  {
    $this->data = array();
  }//end public function cleanEntrys

  /**
   * @return void
   */
  public function setParser($buildr )
  {
    $this->buildrName = $buildr;
  }//end public function setParser

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return string
   */
  public function build( )
  {

    $html = '<ul class="wgtMenu crumb" >'.NL;

    foreach($this->data as $menuPoint )
      $html .= $menuPoint->build().NL;

    $html .= '</ul>'.NL;

    return $html;

  } // end public function defaultParser( )

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax()
  {
    ///TODO find a better way than that to prevent sending as item
    return'';
  }

}// end class WgtMenuCrumbmenu

