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
 * @subpackage wgt
 */
class WgtBuilderTreemenu
{

  /**
   * @var string
   */
  public $url = '';
  
  /**
   * Die HTML Id für das Menü
   * @var string
   */
  public $id = null;

  /**
   * @var string
   */
  public $actionClass = 'wgt-tree';

  /**
   * @var string
   */
  public $innerNode = 'ul';

  /**
   * @var array
   */
  protected $rootNodes = array();

  /**
   * @var array
   */
  protected $childNodes = array();

  /**
   * @var array
   */
  protected $html = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setter für den Datenarray aus der Datenbank
   * @param array $rawData
   */
  public function setRawData( $rawData )
  {

    $this->rootNodes  = array();
    $this->childNodes = array();

    foreach( $rawData as $row )
    {
      if( !$row['parent'] )
      {
        $this->rootNodes[] = $row;
      }
      else
      {
        $this->childNodes[$row['parent']][] = $row;
      }
    }

  }//end public function setRawData */
  
  /**
   * @return string
   */
  public function buildMenu()
  {
    
    if( !$this->id )
      $this->id = 'wgt-tree-'.WebFrap::uniqid();
    

    $this->html = '<ul class="'.$this->actionClass.'" >'.NL;

    foreach( $this->rootNodes as $row )
    {
      $this->html .= '<li>'.NL;
      $this->html .= '<h2><a href="'.$this->url.$row['url_key'].'">'.$row['label'].'</a></h2>'.NL;
      $this->buildSubmenu( $row['rowid'] );
      $this->html .= '</li>'.NL;
    }

    $this->html .= '</ul>'.NL;

  }//end public function buildMenu */

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function buildSubmenu( $subKey )
  {

    if(!isset($this->childNodes[$subKey]))
      return;

    $data = $this->childNodes[$subKey];

    $this->html .= '<'.$this->innerNode.'>'.NL;
    foreach( $data as $row )
    {
      $this->html .= '<li>'.NL;
      $this->html .= '<a href="'.$this->url.$row['url_key'].'">'.$row['label'].'</a>'.NL;
      $this->buildSubmenu( $row['rowid'] );
      $this->html .= '</li>'.NL;
    }
    $this->html .= '</'.$this->innerNode.'>'.NL;

  }//end public function buildSubmenu */

  /**
   * @return string
   */
  public function build()
  {
    $this->buildMenu();
    return $this->html;
  }//end public function build */


} // end class WgtAbstract

