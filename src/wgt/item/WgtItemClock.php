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
 * class WgtItemInput
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtItemClock
  extends WgtItemAbstract
{


  /**
   * Parser for the Clock
   *
   * @return String
   */
  public function build( )
  {


    $id = $this->getId();

    $title = 'KDW Tag: '.( ( 6 + date('w') ) % 7 + 1 ).' KDW: '.date('W');

    $html = "<script type=\"text/javascript\">
      setTimeout('WgtItemClock( \"".$id."\" )',100);
      </script><span>".I18n::s('wbf.text.Clock')."</span><span title=\"".$title."\" id=\"$id\"></span>";

    return $html;

  } // end public function build( )

} // end class WgtItemClock



