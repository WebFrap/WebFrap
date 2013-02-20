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
 * class WgtItemAutocomplete
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputButtonSubmit extends WgtInput
{

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function build($attributes = array() )
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    $this->attributes['type'] = 'submit';

    $attributes = $this->asmAttributes();

    $html = '<input '.$attributes.' />'.NL;

    return $html;

  } // end public function build( )

} // end class WgtItemInput

