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
   * @var Model
   */
  protected $model  = null;

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
  public function icon($name , $alt )
  {
    return Wgt::icon($name, 'xsmall', $alt );
  }//end public function icon */

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isChecked($active , $value )
  {
    return $active === $value? ' checked="checked" ':'';
  }

  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isSelected($active , $value )
  {
    return $active === $value? ' selected="selected" ':'';
  }

  /**
   *
   * @param string $jsCode
   * @return void
   */
  public function addJsCode($jsCode )
  {
    $this->jsCode[] = $jsCode;
  }//end public function addJsCode */
  
  /**
   *
   * @param string $active
   * @param string $value
   */
  public function isActive($active, $value )
  {
    return $active === $value? ' ui-state-active ':'';
  }
  
  /**
   * 
   * Enter description here ...
   */
  public function openJs()
  {
    ob_start();
  }//end public function openJs */
  
  /**
   * 
   * Enter description here ...
   */
  public function closeJs()
  {
    $jsCode = trim(ob_get_contents());
    // @ is required to prevent error for empty tags
    // should normaly not happen, but it would not be an error if 
    // so ignore warnings
    @ob_end_clean(); 
    
    // remove <script></script>
    /// TODO implement this less error-prone 
    $jsCode = substr($jsCode, 8, -9 );
    
    if ( '' !== $jsCode )
      $this->addJsCode($jsCode );
    
  }//end public function closeJs */

} // end class LibTemplateHtml

