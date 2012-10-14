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
 * class WgtItemButton
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputButton
  extends WgtInput
{


  /**
   *
   *
   * @return string
   */
  public function build( $attributes = array() )
  {

    if($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    if(!isset($this->attributes['class']))
      $this->attributes['class'] = 'wgt-button';

    $attributes = $this->asmAttributes();
    $html = '<button name="'.$this->getName().'" '.$attributes.' />'.NL;

    return $html;

  } // end public function build( )

} // end class WgtItemButton


