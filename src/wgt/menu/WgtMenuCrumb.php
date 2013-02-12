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
 * @subpackage tech_core
 */
class WgtMenuCrumb
  extends WgtMenuEntryAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /** Parserfunktion
   *
   * @return String
   */
  public function build( )
  {

    $title = is_null($this->title)?'title="'.$this->title.'"':'';
    $url = $this->data;

    $icon = '';

    if ($this->icon) {
      $icon = '<img src="'.View::$iconsWeb.'xsmall/'.$this->icon.'" class="icon xsmall" />'.NL;
    }

    return '<li style="vertical-align:middle;" ><a class="'.$this->class.'" '.$title.' href="'.$url.'">'.$icon.$this->text.' '.$this->seperator.' </a></li>';

  } // end public function build( )

} // end class WgtMenuCrumb
