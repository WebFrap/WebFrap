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
class MaintenanceDb_Index_Ajax_View extends LibTemplateAjaxView
{
  
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayRecalc( $params )
  {
    
    $response = $this->getResponse();
    
    $response->addMessage( 'Sucessfully recalculated the Data index' );
    
  }//end public function displayRecalc */

  
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayRecalcEntity( $params )
  {
    
    $response = $this->getResponse();
    
    $response->addMessage( 'Sucessfully recalculated the Data index' );
    
  }//end public function displayRecalcEntity */

}//end class DaidalosBdlModules_Ajax_View

