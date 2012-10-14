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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtWindowButton
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  public $type;

  /**
   *
   * @var string
   */
  public $name;

  /**
   *
   * @var string
   */
  public $text;

  /**
   *
   * @var string
   */
  public $class;

  /**
   *
   * @var string
   */
  public $action;

  /**
   * the icon for the button
   * must be relativ to the themepath
   * @var string
   */
  public $icon;

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return string
   */
  public function build()
  {

    $class = $this->class
      ? ' class="'.$this->class.'" '
      : '';

    $icon = $this->icon
      ? ' icon="'.$this->icon.'" '
      : '';

    $type = $this->type
      ? ' type="'.$this->type.'" '
      : ' type="button" ';

    return '<button text="'.$this->text.'" '.$type.$icon.$class.'  />'.NL;

  }//end public function build */


}// end class WgtButton


