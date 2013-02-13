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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAnnouncement_Crud_Create_Modal_View
  extends WgtModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 825 ;
  
  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 600 ;

/*//////////////////////////////////////////////////////////////////////////////
// Display Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * the default edit form
  * @param int $refId
  * @param TFlag $params
  * @return void
  */
  public function displayForm( $params = null )
  {
    
    $request = $this->getRequest();
    
    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Create Announcement';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/announcement/modal/form_create' );
    
    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'modal';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=Webfrap.Announcement.insert';
    $params->formId      = 'wgt-form-webfrap_announcement';
    
    // Setzen der letzten metadaten
    $this->addVar( 'params', $params );
    $this->addVar( 'context', 'create' );
    
    // Das Create Form Objekt erstellen und mit allen nötigen Daten befüllen
    $form = $this->newForm( 'WebfrapAnnouncement_Crud_Create' );
    $entity = $this->model->getEntity();
    $form->setEntity( $entity );

    // Form Action und ID setzen
    $form->setFormTarget( $params->formAction, $params->formId, $params );
    
    // Potentiell vorhandene Default Werte aus dem POST Array auslesen
    if( $request->method( Request::POST ) )
    {
      $form->fetchDefaultData( $request );
    }

    $form->renderForm( $params );


  }//end public function displayForm */


}//end class WebfrapAnnouncement_Crud_Create_Modal_View

