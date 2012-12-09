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
 * @subpackage maintenance/process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMaintenance_ProcessStatus_Modal_View
  extends WgtModal
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
    /**
    * @var WebfrapMaintenance_Process_Model
    */
    public $model = null;
    
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayForm( $domainNode, $idProcess, $idDset )
  {

    $i18nLabel = $this->i18n->l
    (
      'Change Status',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle( $i18nLabel );
    $this->setLabel( $i18nLabel );

    // set the form template
    $this->setTemplate( 'webfrap/maintenance/process/modal/list_processes', true );
    
    $this->processes = $this->model->getProcesses();

    // Menü und Javascript Logik erstellen
    $this->addMenu( );
    $this->addActions( );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForm */


  


}//end class WebfrapMaintenance_ProcessStatus_Modal_View

