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
 * Eine Ajax area
 * @package WebFrap
 * @subpackage wgt
 */
class WgtAjaxArea
  extends WgtTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Haupt Selektor um einen Area zu definieren
   * jquery selector #., etc
   * @var string
   */
  public $selector = null;
  
  /**
   * jquery content manipulator method oder code execution methode
   *   - html
   *  - replace
   *  - append
   *  - prepend
   *  - text
   *  - val
   *  - function
   *  - eval
   * @var string
   */
  public $action = null;
  
  /**
   * jquery selector #., etc
   * @var string 
   */
  public $check = null;
  
  /**
   * Wenn eine check condition gesetzt wird, dann wird üebr not definiert,
   * ob diese bedingung zutreffen muss oder nicht zutreffen darf
   * um die angefragte aktion auszuführen.
   * @var unknown_type
   */
  public $not = false;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return string
   */
  public function getPosition()
  {
    return $this->selector;
  }


  /**
   * @return string
   */
  public function getAction()
  {
    return $this->action;
  }


  /**
   * @return string
   */
  public function getCheck()
  {
    return $this->check;
  }


  /**
   * @return string
   */
  public function getCheckNot()
  {
    return $this->not;
  }

  
} // end class WgtAjaxArea

