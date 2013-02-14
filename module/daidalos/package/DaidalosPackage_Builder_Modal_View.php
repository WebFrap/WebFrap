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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosPackage_Builder_Modal_View extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var DaidalosPackage_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// form export methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * @param string $key
  * @param TFlag $params
  */
  public function displayPackageList($key, $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Package List for '.$key,
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText );

    $this->addVar( 'packages', $this->model->getPackageList($key ) );
    $this->addVar( 'packageKey', $key );
    $this->addVar( 'type', $params->type );
    
    // set the from template
    $this->setTemplate( 'daidalos/package/modal/package_list' );


    // kein fehler aufgetreten
    return null;

  }//end public function displayPackageList */


}//end class DaidalosPackage_Builder_Maintab_View

