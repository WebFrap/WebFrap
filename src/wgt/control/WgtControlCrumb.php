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
 * @subpackage wgt
 */
class WgtControlCrumb
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
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
   * @param array $paths
   * @param string $url
   */
  public function setPathCrumb( $paths, $url )
  {

    $this->data = array();

    foreach ($paths as $path => $label) {
      $this->data[] = array
      (
        $label,
        $url.$path,
        ''
      );
    }

  }//end public function setPathCrumb */

  /**
   * @return string
   */
  public function buildCrumbs()
  {

    $baseFolder = View::$iconsWeb.'/xsmall/';

    $html = '<ul class="wgt-menu crumb inline" >';

    $html .= '<li>/</li>';

    $entries = array();

    foreach ($this->data as $crumb) {

      $text = $crumb[0];
      $url  = $crumb[1];
      $src  = $crumb[2];
      $icon = '';

      if ( '' != trim($src) ) {
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

} // end class WgtControlCrumb
