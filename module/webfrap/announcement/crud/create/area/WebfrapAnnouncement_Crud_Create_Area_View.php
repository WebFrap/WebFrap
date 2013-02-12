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
class WebfrapAnnouncement_Crud_Create_Area_View
  extends LibTemplateAreaView
{

 /**
  * Methode zum befüllen des WbfsysAnnouncement Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayForm( $params )
  {

    // laden der benötigten Resource Objekte
    $request = $this->getRequest();

    $this->position = '#wgt-box-webfrap_announcement-form';

    // set the form template
    $this->setTemplate( 'webfrap/announcement/area/crud/form_create' );

    // Setzen von Viewspezifischen Control Flags
    $params->viewType  = 'area';
    $params->viewId    = $this->getId();

    // Form Target und ID definieren
    $params->formAction  = 'ajax.php?c=Webfrap.Announcement.insert';
    $params->formId     = 'wgt-form-webfrap_announcement';

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
    if ( $request->method( Request::POST ) ) {
      $form->fetchDefaultData( $request );
    }

    $form->renderForm( $params );

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForm */

}//end class WbfsysAnnouncement_Table_Ajax_View
