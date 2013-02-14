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
class WebfrapMaintenance_Metadata_Log_Modal_View extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
    /**
    * @var WebfrapMaintenance_Metadata_Model
    */
    public $model = null;
    
    /**
     * @var int
     */
    public $width = 600;
    
    /**
     * @var int
     */
    public $height = 500;
    
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * Methode zum befüllen des WbfsysMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayLog(  )
  {

    $i18nLabel = $this->i18n->l
    (
      'Clean Log',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel );
    $this->setLabel($i18nLabel );

    // set the form template
    $this->setTemplate( 'webfrap/maintenance/metadata/clean_log', true );

  }//end public function displayLog */

}//end class WebfrapMaintenance_Metadata_Log_Modal_View

