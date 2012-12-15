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
    
    /**
     * @var WbfsysProcess_Entity
     */
    public $processNode = null;
    
    /**
     * @var DomainNode
     */
    public $domainNode = null;
    
    /**
     * Die id des Datensatzes für welchen der Prozess geändert werden soll
     * @var int
     */
    public $vid = null;
    
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
  public function displayForm(  )
  {

    $i18nLabel = $this->i18n->l
    (
      'Update Process',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle( $i18nLabel );
    $this->setLabel( $i18nLabel );

    // set the form template
    $this->setTemplate( 'webfrap/maintenance/process/modal/switch_status', true );



  }//end public function displayForm */


  


}//end class WebfrapMaintenance_ProcessStatus_Modal_View

