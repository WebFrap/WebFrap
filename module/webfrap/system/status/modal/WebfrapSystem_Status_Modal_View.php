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
 * @subpackage Taskplanner
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSystem_Status_Modal_View
  extends WgtModal
{

  public $width = 950;

  public $height = 650;

////////////////////////////////////////////////////////////////////////////////
// form export methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * @param TFlag $params
  */
  public function displayInfo(  )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'PHP Info',
      'wbf.label'
    );


    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setLabel( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/system/status/modal/php_info', true );


    // kein fehler aufgetreten
    return null;

  }//end public function displayList */

}//end class WebfrapSystem_Status_Modal_View

