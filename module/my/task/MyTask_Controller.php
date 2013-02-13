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
class MyTask_Controller
  extends ControllerCrud
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'listing',
    'search',
  );

/*//////////////////////////////////////////////////////////////////////////////
// reports
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Ausgaben eines Listenelements
   * 
   * @param TFlag $params
   * @return void
   */
  public function listing( $params = null )
  {

    // resource laden
    $request   = $this->getRequest();
    $response  = $this->getResponse();
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !($request->method( Request::GET)) )
    {

      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'The request method {@method@} is not allowed for this action! Use {@use@}.',
          'wbf.message',
          array
          (
            'method' => $request->method(),
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );
      return false;

    }

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $params );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_task-listing';
  
    
    $access = new MyTask_Table_Access();
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->listing  )
    {
      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'You have no permission to access this mask!',
          'wbf.message'
        ),
        Response::FORBIDDEN
      );
      return false;
    }
    
    $view = $response->loadView
    (
      'my_task-listing',
      'MyTask_Table',
      'displayListing'
    );


    if( !$view )
    {
      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      $this->errorPage
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
      return null;
    }

    // da wir ein paging implementieren wollen muss die query prüfen
    // wieviele datensätze sie ohne das limit hätte laden können
    // loadFullSize setzt das flag diese information zu laden
    $params->loadFullSize = true;

    // da wir das model hier nicht brauchen packen wir es direkt in die view
    $view->setModel( $this->loadModel( 'MyTask_Table' ) );
    $view->setModelCrud( $this->loadModel( 'MyTask_Crud' ) );

    // ok zusammenbauen der ausgabe
    $error = $view->displayListing( $params );

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

  } // end public function listing */
    
 /**
  * Die Suchefunktion, liefert Daten im Format passend zu Listmethode
  *
  * Diese Methode wird sowohl für die Suche, als auch für einfach Paging oder Append
  * Operationen auf dem Hauplistenelement verwendet
  *
  * @call GET/POST: maintab.php?c=Enterprise.Company.search
  * {
  *   @get_param: cname ltype, der Type der des Listenelements. Sollte sinnigerweise
  *     der gleich type wie das Listenelement sein, für das die Suche angestoßen wurde
  *
  *   @get_param: int start, Offset für die Listenelemente. Wird absolut übergeben und nicht
  *     mit multiplikator ( 50 anstelle von <strike>5 mal listengröße</strike> )
  *
  *   @get_param: int qsize, Die Anzahl der zu Ladenten Einträge. Momentan wird alles > 500 auf 500 gekappt
  *     alles kleiner 0 wird auf den standardwert von aktuell 25 gesetzt
  *
  *   @get_param: array(string fieldname => string [asc|desc] ) order, Die Daten für die Sortierung
  *
  *   @get_param: char begin, Mit Begin wird ein Buchstabe übergeben, der verwendet wird die Listeelemente
  *     nach dem Anfangsbuchstaben zu filtern. Kann im Prinzip jedes beliebige Zeichen, also auch eine Zahl sein
  *
  *   @get_param: ckey target_id, Die HTML Id, des Zielelements. Diese ID is wichtig, wenn das HTML Element
  *     in dem das Suchergebniss platziert werden soll, eine andere ID als die in der Methode hinterlegt
  *     Standard HTML ID hat
  *
  *
  *   @post_param: Die POST-Üparameter sind im Gegensaz zu den GET-Parametern dynamisch.
  *   Es werden lediglich suchfelder ausgewertet
  * }
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function search( $params = null )
  {

    // resource laden
    $request   = $this->getRequest();
    $response  = $this->getResponse();
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !($request->method( Request::GET) || $request->method(Request::POST)) )
    {

      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'The request method {@method@} is not allowed for this action! Use {@use@}.',
          'wbf.message',
          array
          (
            'method' => $request->method(),
            'use'    => 'GET or POST'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );
      return false;

    }

    // laden der steuerungs parameter
    $params  = $this->getListingFlags( $params );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_task-listing';
    
    $access = new MyTask_Table_Access();
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->listing  )
    {
      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'You have no permission to access this mask!',
          'wbf.message'
        ),
        Response::FORBIDDEN
      );
      return false;
    }

    // access direkt übergeben
    $params->access = $access;

    // definiere, dass dies ein ajax request ist
    // diese information ist später wichtig um entscheiden zu können in welcher
    // form das listenelement in den element index übergeben werden soll
    $params->ajax = true;

    // when we not append, then we need to load the full size for paging
    $params->loadFullSize = true;

    $model   = $this->loadModel( 'MyTask_Table' );

    $view = $response->loadView
    (
      'my_task-listing',
      'MyTask_Table',
      'displaySearch'
    );


    if( !$view )
    {
      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      $this->errorPage
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
      return null;
    }

    $view->setModel( $model );
    $error =  $view->displaySearch($params );


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

  }//end public function search */

}//end class MyBase_Controller

