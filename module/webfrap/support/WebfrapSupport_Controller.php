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
class WebfrapNavigation_Controller
  extends ControllerCrud
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'explorer',
    'search'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'about';

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return void
   */
  public function explorer( )
  {

    switch( $this->tplEngine->type )
    {
      case View::SUBWINDOW:
      {
        // use window view
        $view   = $this->tplEngine->newWindow
        (
          'WebfrapMainMenu',
          'WebfrapNavigation'
        );
        break;
      }
      case View::MAINTAB:
      {
        // use maintab view
        $view   = $this->tplEngine->newMaintab
        (
          'WebfrapMainMenu',
          'WebfrapNavigation'
        );
        break;
      }
      case View::MAINWINDOW:
      {
        // use maintab view
        $view   = $this->tplEngine->newMainwindow
        (
          'WebfrapMainMenu',
          'WebfrapNavigation'
        );
        break;
      }
      default:
      {
        $view = $this->view;
      }
    }

    $view->display('root', new TArray() );


  } // end public function menu */
  
  /**
   * @param TFlag $params
   * @return void
   */
  public function search( $params = null )
  {

    // benötigte resourcen laden
    $request   = $this->getRequest();
    $response  = $this->getResponse();
    $user      = $this->getUser();

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $params );

    /*
    $access = new WbfsysBan_Acl_Access_Container();
    $access->load( $user->getProfileName(),  $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l('Ban','wbfsys.ban.label')
          )
        ),
        Response::FORBIDDEN
      );
      return false;
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;
    */
    
    $searchKey  = $this->request->param( 'key', Validator::TEXT );

    $model = $this->loadModel( 'WebfrapNavigation' );

    $view   = $this->tplEngine->loadView( 'WebfrapNavigation_Ajax' );
    $view->setModel( $model );

    $error = $view->displayAutocomplete( $searchKey, $params );


    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if( $error )
    {
      $this->errorPage( $error );
      return false;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return true;

  } // end public function search */



}//end class ControllerWebfrapBase

