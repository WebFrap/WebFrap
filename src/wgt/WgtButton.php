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
 * @subpackage wgt
 */
class WgtButton
{
////////////////////////////////////////////////////////////////////////////////
// Constantes
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * type des buttons
   * @var unknown_type
   */
  const TYPE = 0;

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
  public $icon;

  /**
   *
   * @var string
   */
  public $action;

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

    return '<button '.$type.$icon.$class.' >'.$this->text.'</button>';

  }//end public function build */

  /**
   * @return string
   * /
  public function buildSubwindow()
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

    return '<button '.$type.$icon.$class.' >'.$this->text.'</button>';

  }//end public function build */


  /**
   * @return string
   */
  public function buildMaintab()
  {

    $class = $this->class
      ? ' class="wgt-button '.$this->class.'" '
      : ' class="wgt-button" ';

    $icon = $this->icon
      ? Wgt::icon($this->icon, 'xsmall', $this->text)
      : '';

    return '<button '.$class.' tabindex="-1" >'.$icon.$this->text.'</button>';

  }//end public function buildMaintab */


}// end class WgtButton


