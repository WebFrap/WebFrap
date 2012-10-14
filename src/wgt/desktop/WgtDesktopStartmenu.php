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
 */
class WgtDesktopStartmenu
  extends WgtDesktopElement
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the data array
   *
   * @var array
   */
  protected $data     = array();

  /**
   * name of the menu
   *
   * @var string
   */
  protected $name     = null;

  /**
   * the html id for the menu
   *
   * @var string
   */
  protected $id       = null;

  /**
   *  html
   *
   * @var string
   */
  protected $html     = null;


////////////////////////////////////////////////////////////////////////////////
// Magic
////////////////////////////////////////////////////////////////////////////////

  /**
   * constructor
   * @param string $name
   * @param string $source
   * @return string
   */
  public function __construct( $name , $source = null )
  {
    $this->name = $name;

    if($source)
      $this->source = $source;

    $this->id = 'wgt_menu_'.$name;

  }//end public function __construct */

  /**
   * the to string method
   *
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * setter for the menu id
   *
   * @param string $id
   */
  public function setId( $id )
  {
    $this->id = $id;
  }//end public function setId */

  /**
   * @param array $data
   */
  public function setData( $data )
  {
    $this->data = $data;
  }//end public function setData */


  /**
   *  the menu to html
   * @return string
   */
  public function toHtml()
  {
    if( $this->html )
    {
      return $this->html;
    }
    else
    {
      return $this->build( );
    }
  }//end public function toHtml */

  /**
   * @return void
   */
  protected function sortData()
  {

    $tmps = $this->data;
    $this->data = array();

    foreach( $tmps as $tmp )
    {
      if( !$tmp['id_parent'] )
      {
        $this->data[0][] =  $tmp;
      }
      else
      {
        $this->data[$tmp['id_parent']][] =  $tmp;
      }
    }

  }//end protected function sortData */

  /**
   *
   * @return string
   */
  public function build()
  {

    if(!is_null( $this->html ))
      return $this->html;

    $this->sortData();

    $startImage = Wgt::image('webfrap/header.menu_start.jpg',array('alt'=>'logo','class','left'),true);

    $this->html = <<<HTML
<ul class="wgt-dropmenu" >
  <li style="margin:0px;padding:0px;height:31px;"  >
    <div style="margin:0px;padding:0px;width:63px;height:31px;" >
      <p style="margin:0px;padding:0px;width:63px;height:31px;border:0px;" >
        {$startImage}
      </p>
    </div>
    <ul style="margin-top:5px;">
HTML;

    foreach( $this->data as $entry )
    {
      $this->html .= $this->buildEntry( $entry );
    }

    $this->html .= '</ul></li></ul>'.NL;

    return $this->html;


  }//end public function build */

  /**
   *
   * @param array $entry
   */
  public function buildEntry( $entry )
  {

    $html = '<li>'.NL;

    $icon = '';
    if( '' == trim($entry['icon']) )
    {
      $src  = View::$iconsWeb.'xsmall/'.$entry['icon'];
      $icon = '<img src="'.$src.'" alt="'.$entry['label'].'" class="icon xsmall" /> ';
    }

    if( '' != trim($entry['url']) )
    {
      $html .= '<a class="wcm wcm_req_ajax" href="maintab.php?c='.$entry['url'].'" >'.$icon.$entry['label'].'</a>'.NL;
    }
    else
    {
      $html .= '<p class="wcm wcm_req_ajax" >'.$icon.$entry['label'].'</p>'.NL;
    }

    if( isset( $this->data[$entry['rowid']] ) )
    {
      $html .= '<ul>'.NL;
      $html .= $this->buildEntry( $entry );
      $html .= '</ul>'.NL;
    }

    $html .= '</li>'.NL;

    return $html;

  }//end public function buildEntry */

} // end class WgtStartmenu

