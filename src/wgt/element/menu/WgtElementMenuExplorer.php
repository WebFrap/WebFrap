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
class WgtElementMenuExplorer
  extends WgtMenu
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var int
   */
  const DEF_ROWS          = 8;

  /**
   * @var string
   */
  protected $baseFolder   = null;

  /**
   * @var string
   */
  protected $interface   = 'maintab.php';

  /**
   *
   * @var array
   */
  public $crumbs = array();

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtMenu#setData()
   */
  public function setData( $data )
  {
    $this->data = $data;
  }//end public function setData */

  /**
   * @return string
   */
  public function buildCrumbs()
  {

    Debug::console('in build crumbs');
    
    if( $this->data )
      $crumbs = $this->data->crumbs;
    else
      $crumbs = array();

    /*
    if(!$crumbs)
      return '';
    */

    $baseFolder = View::$iconsWeb.'/xsmall/';

    $html = '<ul class="wgt-menu crumb inline" >';

    $html .= '<li>/</li>';

    $entries = array();

    foreach ( $crumbs as $crumb )
    {

      $text = $crumb[0];
      $url  = $crumb[1];
      $src  = $crumb[2];
      $icon = '';

      if( '' != trim($src) )
      {
        $icon = '<img class="icon xsmall" '.
        ' src="'.$baseFolder.$src.'" '.
        ' alt="'.$text.'"  /> ';
      }


      $entries[] = '<li><a style="border:0px;" class="wcm wcm_req_ajax" href="'.$url.'" >'.$icon.$text.'</a></li>';

    }

    $html .= implode('<li>/</li>', $entries);

    $html .= '</ul>';

    return $html;


  }//end public function buildCrumbs

  /**
   *
   * @return string
   */
  public function build( )
  {

    $this->baseFolder = View::$iconsWeb.'/medium/';

    if(  $this->sort )
    {

      $folders  = array();
      $files    = array();

      if( isset($this->data->folders) && $this->data->folders )
      {
        foreach( $this->data->folders as $entry )
        {
          $folders[$entry[2]] = $entry;
        }
        ksort($folders);
      }

      if( isset($this->data->files) && $this->data->files )
      {
        foreach( $this->data->files as $entry )
        {
          $files[$entry[2]] = $entry;
        }
        ksort($files);
      }

    }
    else
    {
      
      $folders = isset($this->data->folders)  
        ? $this->data->folders
        : array();
        
      $files   = isset($this->data->files)
        ? $this->data->files
        : array();
    }



    $html = '<div class="wgt-menu folder" >'.NL;

    if( isset($this->data->firstEntry) && $this->data->firstEntry )
    {
      $html .= $this->genTabrow( $this->data->firstEntry );
    }

    $pos = 0;

    // Generieren der Rows
    foreach ( $folders as $entry )
    {
      $html .= $this->genTabrow( $entry );
    }

    foreach ( $files as $entry )
    {
      $html .= $this->genTabrow( $entry );
    }

    $html .= '</div>'.NL;

    $this->html = $html;

    return $html;

  } // end  public function build */



  /**
   *
   * @return
   */
  protected function genTabrow( $pic )
  {

    if( $pic[WgtMenu::ICON] != '' || trim($pic[WgtMenu::TEXT]) != '' )
    {

      $text = trim( $pic[WgtMenu::TEXT] ) != '' ? $pic[WgtMenu::TEXT].'<br />' : '';

      if( Wgt::ACTION == $pic[WgtMenu::TYPE] )
      {
        $link = $text.'<img class="icon large cursor" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';
      }
      else if( Wgt::URL == $pic[WgtMenu::TYPE] )
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      }
      else if( Wgt::AJAX == $pic[WgtMenu::TYPE] )
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      }
      else if( Wgt::WINDOW == $pic[WgtMenu::TYPE] )
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      }
      else
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.'<p>'.$text.'</p></a>';
      }

    }
    else
    {
      $link =  '&nbsp;';
    }

    return '<div class="wgt-entry" >'.$link.'<div class="" > </div></div>'.NL;

  }//end protected function genTabrow */

} // end class WgtMenuFolder


