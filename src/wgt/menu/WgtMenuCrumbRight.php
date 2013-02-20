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
class WgtMenuCrumbRight extends WgtMenuEntryAbstract
{

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /** Parserfunktion
   *
   * @return String
   */
  public function build( )
  {

    $title = is_null($this->title)?'title="'.$this->title.'"':'';

    if (!is_array($this->data)) {
      $this->data = SParserString::seperatedToKeyArray($this->data ,'-');
    }

    $url = TUrl::asUrl( 'index.php',$this->data,str_replace( ' ', '-', $this->text )) ;

    $icon = '';

    if ($this->icon) {
      $icon = '<img src="'.View::$iconsWeb.'xsmall/'.$this->icon.'" class="icon xsmall" />'.NL;
    }

    return '<span style="vertical-align:middle;float:right;" ><a '.$title.' href="'.$url.'">'.$icon.$this->text.' </a></span>';

  } // end public function build( )

} // end class WgtMenuCrumbRight

