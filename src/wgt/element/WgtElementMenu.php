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
class WgtElementMenu extends WgtMenu
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

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

  /**
   * @var string
   */
  public $title = null;

  /**
   * @var string
   */
  public $label = null;

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtMenu#setData()
   */
  public function setData($data)
  {
    $this->data = $data;
  }//end public function setData */

  /**
   * @return string
   */
  public function buildCrumbs()
  {

    Debug::console('in build crumbs');

    $crumbs = $this->data->crumbs;

    /*
    if (!$crumbs)
      return '';
    */

    $baseFolder = View::$iconsWeb.'/xsmall/';

    $html = '<ul class="wgt-menu crumb inline" style="margin-left:7px;" >';

    $html .= '<li>/</li>';

    $entries = array();

    foreach ($crumbs as $crumb) {

      $text = $crumb[0];
      $url  = $crumb[1];
      $src  = $crumb[2];
      $icon = '';

      if ('' != trim($src)) {
        $icon = '<img class="icon xsmall" '.
        ' src="'.$baseFolder.$src.'" '.
        ' alt="'.$text.'"  /> ';
      }

      $entries[] = '<li><a  class="wcm wcm_req_ajax" href="'.$url.'" >'.$icon.$text.'</a></li>';

    }

    $html .= implode('<li>/</li>', $entries);

    $html .= '</ul>';

    return $html;

  }//end public function buildCrumbs

  /**
   *
   * @return string
   */
  public function build()
  {

    $this->baseFolder = View::$iconsWeb.'/medium/';

    if ($this->sort) {

      $folders  = array();
      $files    = array();

      if (isset($this->data->folders) && $this->data->folders) {
        foreach ($this->data->folders as $entry) {
          $folders[$entry[2]] = $entry;
        }
        ksort($folders);
      }

      if (isset($this->data->files) && $this->data->files) {
        foreach ($this->data->files as $entry) {
          $files[$entry[2]] = $entry;
        }
        ksort($files);
      }

    } else {

      $folders = isset($this->data->folders)
        ? $this->data->folders
        : array();

      $files   = isset($this->data->files)
        ? $this->data->files
        : array();
    }

    $html = '<ul class="wgt-menu list wgt-space" >'.NL;

    if (isset($this->data->firstEntry) && $this->data->firstEntry) {
      $html .= $this->renderListEntry($this->data->firstEntry);
    }

    $pos = 0;

    // Generieren der Rows
    foreach ($folders as $entry) {
      $html .= $this->renderListEntry($entry, '&amp;mtype=list');
    }

    foreach ($files as $entry) {
      $html .= $this->renderListEntry($entry);
    }

    $html .= '</li>'.NL;

    $this->html = $html;

    return $html;

  } // end  public function build */

  /**
   * @param array $pic
   * @param string $append
   * @return
   */
  protected function renderListEntry($pic, $append = '')
  {

    if ($pic[WgtMenu::ICON] != '' || trim($pic[WgtMenu::TEXT]) != '') {

      $text = trim($pic[WgtMenu::TEXT]) != '' ? $pic[WgtMenu::TEXT].'<br />' : '';

      if (Wgt::ACTION == $pic[WgtMenu::TYPE]) {
        $link = $text.'<img class="icon xsmall cursor" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';
      } elseif (Wgt::URL == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } elseif (Wgt::AJAX == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } elseif (Wgt::WINDOW == $pic[WgtMenu::TYPE]) {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      } else {
        $icon = '<img class="icon xsmall" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax"  href="'.$pic[WgtMenu::ACTION].$append.'" >'.$icon.'<span>'.$text.'</span></a>';
      }

    } else {
      $link =  '&nbsp;';
    }

    return '<li>'.$link.'</li>'.NL;

  }//end protected function renderListEntry */

} // end class WgtElementMenu

