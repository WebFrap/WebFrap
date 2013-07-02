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
abstract class LibTemplatePublisher extends LibTemplate
{

  /**
   * @var array
   */
  protected $cookies  = array();

  /**
   * de:
   * Dropmenu builder für die Maintab, Subwindow etc View Elemente
   * @var WgtDropmenu
   */
  public $menu          = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/lib/LibTemplate::setModel()
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */

/*//////////////////////////////////////////////////////////////////////////////
// small html helper methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * request an icon
   * @param string $name
   * @param string $alt
   * @return string
   */
  public function icon($name , $alt)
  {
    return Wgt::icon($name, 'xsmall', $alt);
  }//end public function icon */

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isChecked($active , $value)
  {
    return $active === $value? ' checked="checked" ':'';
  }

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isSelected($active , $value)
  {
    return $active === $value? ' selected="selected" ':'';
  }
  

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isActive($active, $value)
  {
    return $active === $value? ' ui-state-active ':'';
  }//end public function isActive 


} // end class LibTemplateHtml

