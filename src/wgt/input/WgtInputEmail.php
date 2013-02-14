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
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputEmail extends WgtInput
{

  /**
   * @param array
   * @return string
   */
  public function build( $attributes = array() )
  {


    // ist immer ein text attribute
    if(!isset($attributes['type']))
      $attributes['type'] = 'text';

    $this->texts->afterInput = Wgt::icon('control/mail.png', 'xsmall', 'mail');

    return parent::build($attributes);


  } // end public function build */

} // end class WgtInputText


