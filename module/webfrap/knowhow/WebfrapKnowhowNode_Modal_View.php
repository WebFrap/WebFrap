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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapKnowhowNode_Modal_View
  extends WgtModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 450 ;
  
  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 380 ;

////////////////////////////////////////////////////////////////////////////////
// Display Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * the default edit form
  * @param TFlag $params
  * @return boolean
  */
  public function displayDialog( $params )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Know How Ref';

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/knowhow_node/modal/dialog' );

    
    $this->addVar( 'context', 'protocol' );

    // ok kein fehler aufgetreten
    return null;

  }//end public function displayEntity */


}//end class EnterpriseCompany_Maintenance_Protocol_Modal_View

