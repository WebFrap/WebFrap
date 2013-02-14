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
 * class Controller
 * Extention zum verwalten und erstellen von neuen Menus in der Applikation
 * @package WebFrap
 * @subpackage tech_core
 * @deprecated use MvcController
 */
abstract class Controller extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * the default Action, this action will be called there is no
   * action in the request
   * @var string
   */
  protected $defaultAction  = null;

  /**
   * @var string the default Action
   */
  protected $activAction    = null;

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models         = array();

  /**
   * sub Modul Extention
   * @var Model
   */
  protected $model          = null;

  /**
   * sub Modul Extention
   * @var array
   */
  protected $modelName      = null;

  /**
   * sub Modul Extention
   * @var array
   */
  protected $viewName      = null;

  /**
   * Flag ob der Controller schon initialisiert wurde, und damit einsatzbereit
   * ist zum handeln von requests
   *
   * @var boolean
   */
  protected $initialized  = false;

  /**
   * Alle Methoden welche direkt über ein CallTripple ( c=Simple.Example.helloWorld )
   * angesprochen werden können, müssen hier lowercase! im array angegeben werden.
   *
   * Klappt nicht?
   * Häufige Fehler / Fehlerquellen:
   *  - eintrag in callAble vergessen
   *  - eintrag nicht lowercase
   *  - buchstabendreher
   *  - methode ist nicht public und kann deshalb nicht aufgerufen werden
   *  - call tripple enthält weniger als genau 3 werte
   *  - beim aufruf das c= vor dem tripple vergessen
   *  - ? anstelle von & als url trenner
   *
   * @example
   * protected $publicAccess       = array
   * (
   *   'helloworld',
   *   'callable'
   * );
   *
   * @var array
   * @deprecated use service_ prefix and options instead
   */
  protected $callAble           = array();

  /**
   * Liste der Services welche über diesen Controller angeboten werden.
   *
   * Listet für jeden Service die HTTP Methoden die Valide sind, sowie
   * die Attribute und Datenfelder welcher akzeptiert werden
   *
   * Kann zu XML oder Json Serialisiert werden
   *
   * Klappt nicht?
   * Häufige Fehler / Fehlerquellen:
   *  - eintrag in callAble vergessen
   *  - eintrag nicht lowercase
   *  - Buchstabendreher
   *  - methode ist nicht public und kann deshalb nicht aufgerufen werden
   *  - call tripple enthält weniger als genau 3 werte
   *  - beim aufruf das c= vor dem tripple vergessen
   *  - ? anstelle von & als url trenner
   *
   * @example
   * protected $options = array
   * (
   *   'helloworld' => array
   *   (
   *     'method'    => array( 'GET', 'POST' ),
   *     'interface' => array
   *     (
   *        'GET' => array
   *       (
   *         'param' => array
   *          (
   *           'name' => array( 'type' => 'string', 'semantic' => 'The Name of the Whatever', 'required' => true, 'default' => 'true' ),
   *          ),
   *       )
   *       'POST' => array
   *       (
   *          'param' => array
   *          (
   *
   *          ),
   *          'data' => array
   *          (
   *
   *         )
   *       )
   *     ),
   *     'views'       => array
   *     (
   *       'maintab',
   *       'window'
   *     ),
   *     'access'       => 'auth_required',
   *     'description' => 'Hello World Method'
   *     'docref'       => 'some_link',
   *     'author'       => 'author <author@mail.addr>'
   *   )
   * );
   *
   * @var array
   */
  protected $options           = array();


  /**
   * array with the actions that can be access without be loggedin
   * de:
   * {
   *   Alle Methoden die in diesem Array gelistet werden können ohne Authetifizierung
   *   ( Der Benutzer muss nicht eingeloggt sein )
   *   aufgerufen werden.
   *   Die Methodennamen müssen lowercase angegeben werden
   *   @example
   *   protected $publicAccess       = array
   *   (
   *     'helloworld',
   *     'callable'
   *   );
   * }
   * @var array
   */
  protected $publicAccess       = array();

  /**
   * makte the public Access whitelist to a blacklist
   * de:
   * {
   *   Wenn flipPublicAccess auf true gesetzt wird, wird der array in
   *   Controller::$publicAccess als Blacklist anstelle als Whitelist verwendet
   *   Methoden die gelistet werde können dann nur von Authentifizierten Benutzer
   *   gecalled werden
   * }
   * @var boolean
   */
  protected $flipPublicAccess   = false;

  /**
   * ignore accesslist everything is free accessable
   * de:
   * {
   *   Wird fullAccess auf true gesetzt werden alle alle einträge in publicAccess
   *   komplett ignoriert, alle Methoden sind dann ohne Authentifizierung callbar
   *   gecalled werden
   * }
   * @var boolean
   */
  protected $fullAccess         = false;


  /**
   * @lang de:
   * Der Container mit den Zugriffsrecheten auf Module Ebene
   * @var LibAclConatiner
   */
  protected $modAccess       = null;

/*//////////////////////////////////////////////////////////////////////////////
// deprecated attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @deprecated ui objekte sollen in die view
   * @var array
   */
  protected $uis            = array();

  /**
   *
   * @var string
   * @deprecated
   * @todo prüfen ob das ding problemlos gelöscht werden kann
   */
  public $listMethod    = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor and other Magics
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Base $env
   */
  public function __construct( $env = null )
  {

    if (!$env )
      $env = Webfrap::getActive();

    $this->env = $env;

    if( DEBUG )
      Debug::console( 'Load Controller '.get_class($this) );

  }//end public function __construct */

  /**
   * default constructor
   */
  public function __destruct( )
  {
    $this->initialized = false;
  } // end public function __destruct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter, Setter and Adder Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /** request the actually activ Action
   * @return string
   */
  public function getActivAction()
  {
    return $this->activAction ;
  }//end public function getActivAction */

  /**
   * request the default action of the ControllerClass
   * @return string
   */
  public function getDefaultAction()
  {
    return $this->defaultAction;
  }//end public function getDefaultAction */


  /**
   * @setter LibAclContainer  Controller::$modAccess
   * @return string
   */
  public function setModAccess( $modAccess )
  {
    $this->modAccess = $modAccess;
  }//end public function setModAccess */

/*//////////////////////////////////////////////////////////////////////////////
// load methodes for loading resources
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Eine Modelklasse laden
   *
   * @param string $modelKey
   * @param string $key
   * @param array $injectKeys
   *
   * @return Model
   * @throws Controller_Exception wenn das angefragt Modell nicht existiert
   */
  public function loadModel( $modelKey, $key = null, $injectKeys = array() )
  {

    if( is_array( $key ) )
      $injectKeys = $key;

    if (!$key || is_array( $key ) )
      $key = $modelKey;


    $modelName    = $modelKey.'_Model';
    $modelNameOld = 'Model'.$modelKey;

    if (!isset( $this->models[$key]  ) )
    {
      if( Webfrap::classLoadable( $modelName ) )
      {
        $model = new $modelName( $this );

        foreach( $injectKeys as $injectKey )
        {
          $model->{"set".$injectKey}( $this->{"get".$injectKey}() );
        }

        $this->models[$key] = $model;
      }
      else if( Webfrap::classLoadable( $modelNameOld ) )
      {
        $model = new $modelNameOld( $this );

        foreach( $injectKeys as $injectKey )
        {
          $model->{"set".$injectKey}( $this->{"get".$injectKey}() );
        }

        $this->models[$key] = $model;
      }
      else
      {
        throw new Controller_Exception
        (
          'Internal Error',
          'Failed to load Submodul: '.$modelName
        );
      }
    }

    return $this->models[$key];

  }//end public function loadModel */

  /**
   * de:
   * {
   *  @getter Model
   * }
   * @param $key
   * @return Model
   */
  public function getModel( $key )
  {

    if( isset( $this->models[$key] ) )
      return $this->models[$key];
    else
      return null;

  }//public function getModel */


  /**
   * @param string $name
   * @return void
   * @deprecated use setDefaultModel
   */
  public function setModel( $name )
  {
    $this->modelName = ''.$name.'_Model';
  }//end public function setModel */

  /**
   * @param string $name
   * @return void
   */
  public function setDefaultModel( $name )
  {

    if( $this->modelName || (is_bool($this->modelName) && false == $this->modelName  ) )
      return;

    $this->modelName = $name.'_Model';

  }//end public function setDefaultModel */


  /**
   *
   * @return LibFlow
   */
  public function getFlowController(  )
  {

    return Webfrap::getActive();

  }//public function getFlowController */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * run a method if it exists
   * de:
   * {
   *  prüfen ob eine bestimmte methode auf dem controller existiert.
   *
   *  (wird benötigt um zu prüfen ob eine im request angefragte methode überhaupt
   *  existiert)
   * }
   *
   * @return boolean
   */
  protected function methodeExists( $methodeName )
  {

    return method_exists( $this , $methodeName  );

  }//end protected function methodeExists */

  /**
   * Den Aufruf an einen Subcontroller weiterrouten
   *
   * @param string $conKey
   * @param string do
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   *
   * @throws Webfrap_Exception
   */
  public function routeToSubcontroller( $conKey, $do, $request, $response )
  {

    $request   = $this->getRequest();
    $response  = $this->getResponse();

    try
    {

      $className = $conKey.'_Controller';

      if (!Webfrap::classLoadable( $className ) )
      {
        throw new InvalidRoute_Exception( $className );
      }

      $controller = new $className();

      // Initialisieren der Extention
      if (!$controller->initController( ) )
        throw new Webfrap_Exception( 'Failed to initialize Controller' );

      // Run the mainpart
      $controller->run( $do );

      // shout down the extension
      $controller->shutdownController( );

    }
    catch( Exception $exc )
    {

      Error::report
      (
        $response->i18n->l
        (
          'Module Error: {@message@}',
          'wbf.message' ,
          array
          (
            'message' => $exc->getMessage()
          )
        ),
        $exc
      );

      $type = get_class($exc);

      if( Log::$levelDebug )
      {
        // Create a Error Page
        $this->errorPage
        (
          $exc->getMessage(),
          Response::INTERNAL_ERROR,
          '<pre>'.Debug::dumpToString($exc).'</pre>'
        );

      }
      else
      {
        switch( $type )
        {
          case 'Security_Exception':
          {
            $this->errorPage
            (
              $response->i18n->l( 'Access Denied', 'wbf.message'  ),
              Response::FORBIDDEN
            );
            break;
          }
          default:
          {

            if( Log::$levelDebug )
            {
              $this->errorPage
              (
                'Exception '.$type.' not catched ',
                Response::INTERNAL_ERROR,
                Debug::dumpToString($exc)
              );
            }
            else
            {
              $this->errorPage
              (
                $response->i18n->l(  'Sorry Internal Error', 'wbf.message'  ),
                Response::INTERNAL_ERROR
              );
            }

            break;

          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch

  }//end public function routeToSubcontroller */

  /**
   * die vom request angeforderte methode auf rufen
   * @param string $action
   */
  public function run( $action = null )
  {

    // wenn ein klassenname für eine standard modell klasse definiert wurde
    // versucht der controller nun automatisch ein objekt dies modells zu erstellen
    if( $this->modelName )
    {
      $modelClass = $this->modelName;

      // only load if not yet set and loadable
      if (!$this->model && Webfrap::loadable( $modelClass ) )
        $this->model = new $modelClass( $this );
    }

    if (!$this->checkAction( $action ) )
      return;

    $this->runIfCallable( $action );

  }//end public function run */

  /**
   * @param string $methodeName
   * @param string $view
   */
  public function runIfCallable( $methodeKey, $view = null )
  {

    $request   = $this->getRequest();
    $response  = $this->getResponse();


    $methodeKey = strtolower( $methodeKey );

    if (!in_array( $methodeKey, $this->callAble ) )
    {

      $methodeName = 'service_'.$methodeKey;

       if( method_exists( $this, $methodeName ) )
       {

         try
         {

           // prüfen der options soweit vorhanden
           if( isset( $this->options[$methodeKey] ) )
           {

             // prüfen ob die HTTP Methode überhaupt zulässig ist
             if
             (
               isset( $this->options[$methodeKey]['method'] )
                 && !$request->method( $this->options[$methodeKey]['method'] )
             )
             {
              throw new InvalidRequest_Exception
              (
                $response->i18n->l
                (
                  'The request method {@method@} is not allowed for this action! Use {@use@}.',
                  'wbf.message',
                  array
                  (
                    'method' => $request->method(),
                    'use'    => implode( ' or ', $this->options[$methodeKey]['method'] )
                  )
                ),
                Request::METHOD_NOT_ALLOWED
              );

             }

             if
             (
               isset( $this->options[$methodeKey]['views'] )
                 && !$response->tpl->isType( $this->options[$methodeKey]['views'] )
             )
             {

               throw new InvalidRequest_Exception
               (
                 $response->i18n->l
                 (
                   'Invalid format {@type@}, valid formats are: {@use@}',
                   'wbf.message',
                   array
                   (
                     'type' => $response->tpl->getType(),
                     'use'  => implode( ' or ', $this->options[$methodeKey]['views'] )
                   )
                 ),
                 Request::NOT_ACCEPTABLE
               );

             }

             if( isset( $this->options[$methodeKey]['ssl'] ) )
             {

               if( $this->options[$methodeKey]['ssl'] && !$request->isSecure() )
               {
                 throw new InvalidRequest_Exception
                 (
                   $response->i18n->l
                   (
                     'This resource can only be accessed with a secure ssl connection.',
                     'wbf.message'
                   ),
                   Request::BAD_REQUEST
                 );
							 }
             }

             if( isset( $this->options[$methodeKey]['auth'] ) )
             {

               $user = $this->getUser();
               if( $this->options[$methodeKey]['auth'] && !$user->getLogedIn() )
               {
                 throw new InvalidRequest_Exception
                 (
                   $response->i18n->l
                   (
                     'You have to be authentificated to access this resource.',
                     'wbf.message'
                   ),
                   Request::FORBIDDEN
                 );
							 }
             }


           }

           $error = $this->$methodeName( $request, $response  );

           if( $error && is_object( $error ) )
           {
             $this->errorPage( $error );
           }

         }
         catch( Webfrap_Exception $error )
         {
           $this->errorPage
           (
             $error
           );
         }
         catch( Exception $error )
         {
           $this->errorPage
           (
             $error,
             Response::INTERNAL_ERROR
           );
         }

         return;

       }
       else
       {
         if( DEBUG )
         {
           Debug::console( $methodeName.' is not callable!' ,  $this->callAble );

           $methodes = implode( ', ', get_class_methods($this) );
           $response->addError
           (
           	'The action :'.$methodeName .' is not callable on service: '.get_class($this).' methode: '.$methodes.'!'
            );

           $this->errorPage
           (
              'The action :'.$methodeName .' is not callable on service: '.get_class($this).' methode: '.$methodes.'!',
              Response::NOT_FOUND
           );
         }
         else
         {
           $response->addError( 'The action :'.$methodeName .' is not callable on service: '.get_class($this).' !' );
           $this->errorPage
           (
              'The action :'.$methodeName .' is not callable on service: '.get_class($this).' !',
              Response::NOT_FOUND
           );
         }



         return;
       }
    }

    if (!$this->runIfExists( $methodeKey, $view )  )
    {

       $do = $request->param( 'do', Validator::CNAME );

       $this->errorPage
       (
          'Sorry, our Codemonkey failed. The requested Resource '.$do.' not exists',
          Response::INTERNAL_ERROR
       );

     }

     return;

  }//end public function runIfCallable */

  /**
   * run a method if it exists
   *
   * @param string $methodeName
   * @param LibTemplateView $view
   *
   * @return void
   */
  public function runIfExists( $methodeName , $view = null )
  {

    if( method_exists( $this , $methodeName  ) )
    {
      if( $view )
        $this->$methodeName( $view );

      else
        $this->$methodeName( );

      return true;
    }
    else
    {
      return false;
    }

  } // end public function runIfExists */

  /**
   * @param string $action
   * @return void
   */
  protected function checkAction( $action )
  {

    $action = strtolower( $action );
    $this->activAction = $action;

    if( $this->fullAccess )
      return true;

    $user = $this->getUser();
    if( $user->getLogedIn() )
      return true;

    // prüfen mit den options
    if( isset($this->options[$action]['public'])  )
    {

      if( $this->options[$action]['public'] )
      {
        return true;
      }
      else if( $this->login()  )
      {
        return true;
      }

      // wenn false fällt der code direkt zum login redirect
    }
    else if( $this->login()  )
    {
      return true;
    }


    Webfrap::getActive()->redirectToLogin();

    return false;

  }//end protected function checkAction */

  /**
   * Function for reinitializing after wakeup. Is Neccesary caus we can't use
   * the normal __wakeup function without getting race conditions
   * @param array $data
   * @return void
   */
  public function initController( $data = array() )
  {

    if($this->initialized)
      return true;

    $this->initialized = true;

    foreach( $data as $name => $value )
      $this->$name = $value;

    // View und Request und User werden immer benötigt
    // alle anderen sind optional

    $this->getRequest();

    $response = $this->getResponse();
    $response->setMessage( $this->getMessage() );
    $response->setI18n( $this->getI18n() );

    $tpl =  $this->getTplEngine();
    $response->setTplEngine( $tpl );

    $tpl->setI18n( $this->getI18n() );
    $tpl->setUser( $this->getUser() );
    $tpl->setMessage( $this->getMessage() );
    $tpl->setAcl( $this->getAcl() );

    $this->setView($tpl);

    $this->init();

    return true;

  } // end public function initController */

  /**
   * methode for shutting down extention, we use this instead of __sleep
   *
   * @return void
   */
  public function shutdownController( )
  {
    $this->shutDown();
  } // end public function shutdownController */

/*//////////////////////////////////////////////////////////////////////////////
// Controler Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * get the main oid, can be overwritten if needed
   * @param string $key
   * @param string $accessKey
   * @param string $validator
   * @return int/string
   */
  protected function getOID( $key = null, $accessKey = null, $validator = Validator::CKEY )
  {

    $request = $this->getRequest();

    if( $key )
    {
      $id = $request->data( $key, Validator::INT, 'rowid' );

      if($id)
      {
        Debug::console('got post rowid: '.$id);
        return $id;
      }
    }

    $id = $request->param( 'objid', Validator::INT );

    if (!$id && $accessKey )
    {
      if( $key )
      {
        $id = $request->data( $key, $validator, $accessKey );

        if($id)
        {
          Debug::console('got post rowid: '.$id);
          return $id;
        }
      }

      $id = $request->param( $accessKey, $validator );

      Debug::console('got param '.$accessKey.': '.$id);

    }
    else
    {
      Debug::console('got param objid: '.$id);
    }

    return $id;

  }//end protected function getOID

/*//////////////////////////////////////////////////////////////////////////////
// Methodes to overwrite
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Trigger the custom init method of this controller
   */
  public function init(){ return true; }

  /**
   * Overwrite if needed
   * use this instead of destructor
   */
  public function shutDown(){}


/*//////////////////////////////////////////////////////////////////////////////
// error page and messages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * {
   *   Standard
   * }
   *
   * @param string $message
   * @param string $errorCode
   * @param mixed $dump
   *
   * @return void
   */
  public function errorPage( $message, $errorCode = Response::INTERNAL_ERROR, $dump = null )
  {

    if( is_object( $message ) )
    {
      $messageText  = $message->getMessage();

      // Fallback für nicht wbf exceptions
      if( method_exists($message, 'getErrorKey') )
        $errorCode    = $message->getErrorKey();
      else
        $errorCode = Response::INTERNAL_ERROR;
    }
    else
    {
      $messageText  = $message;
    }

    $response = $this->getResponse();
    $response->httpState = $errorCode;

    // bei ajax request wird einfach eine fehlermeldung geworfen
    if
    (
      $response->tpl->isType( View::MAINTAB )
        || $response->tpl->isType( View::MODAL )
        || $response->tpl->isType( View::AJAX )
        || $response->tpl->isType( View::SERVICE )
    )
    {

      $response->sendHeader( "X-error-message: ".urlencode($messageText.' '.$errorCode) );

      $response->addError( $messageText );
    }
    elseif( $response->tpl->isType( View::DOCUMENT ) )
    {

      // Wenn ein dokument angefragt wurde das nicht bearbeitet werden kann
      // wird eine html fehlermeldung zurückgegeben
      // meist sinnvoller als irgendetwas in ein dokument zu pinseln
      View::setType('Html');
      View::rebase('Html');


      // nach rebase wird die neue aktive templateengine geholt
      $this->tplEngine = View::getActive();

      Debug::dumpFile('doc.error', $this->tplEngine);


      //TODO prüfen ob set index und html head in der form bleiben sollen
      $conf = Conf::get('view');
      if( $this->user->getLogedIn() )
      {
        $this->tplEngine->setIndex( $conf['index.user'] );
        $this->tplEngine->setHtmlHead( $conf['head.user'] );
      }
      else
      {
        $this->tplEngine->setIndex( $conf['index.annon'] );
        $this->tplEngine->setHtmlHead( $conf['head.annon'] );
      }

      $this->tplEngine->contentType = View::CONTENT_TYPE_TEXT;

      $this->tplEngine->setIndex('error');

      $this->tplEngine->setTitle( $response->i18n->l( 'An Error occured', 'wbf.label' ) );
      $this->tplEngine->setTemplate( 'error/message'  );
      $this->tplEngine->addVar( 'errorTitle' , $messageText );
      $this->tplEngine->addVar( 'errorMessage' , $message );

    }
    elseif( $response->tpl->isType( View::JSON ) )
    {

      $this->tplEngine->setDataBody( 'error: '.$message );

    }
    else
    {

      $view = $this->getView();

      $view->setTitle( $response->i18n->l( 'Error', 'wbf.label' ) );
      $view->setTemplate( 'error/message'  );
      $view->addVar( 'errorMessage', $message );


    }

  }//end public function errorPage */



  /**
   * check if the access Type is valid
   * @param string / array
   * @return boolea, type valid or invalid
   */
  protected function checkAccessType( $type )
  {

    $response = $this->getResponse();

    // check if the request type is AJAX, if not return an error page
    if (!$response->tpl->isType( $type ) )
    {
      $this->errorPage
      (
        $response->i18n->l
        (
          'Invalid access type {@type@}',
          'wbf.message',
          array( 'type', $type )
        ),
        Response::NOT_IMPLEMENTED
      );
      return false;
    }

    // if not false it must be tree
    return true;

  }//end protected function checkAccessType */

  /**
   * @lang de:
   *
   *   getSubView ist eine Adapter Methode welche versucht automatisch
   *   das passende ViewObjekt, basierende auf der Anfrage, zu erstellen
   *
   * @see <a href="http://127.0.0.1/wbf/doc/de/index.php?page=architecture.gateway.interfaces" >Doku WebFrap Gateway Interfaces</a>
   *
   * @example
   * <code>
   *  $view = $this->getSubView( 'exampleEditForm', 'ExampleDomain' );
   *
   *  if (!$view )
   *  {
   *    $this->invalidAccess
   *    (
   *      $response->i18n->l
   *      (
   *        'The requested View not exists',
   *        'wbfsys.error'
   *      );
   *    );
   *    return false;
   *  }
   * </code>
   *
   * @param string $key schlüssel zum adressieren des view objektes,
   *  wird teils auch in client verwendet
   *
   * @param string $class
   *  der domainspezifische name der view klasse
   *
   * @param string $displayMethod
   *  Die display Methode, welche auf der View erwartet wird,
   *  Wenn die Methode nicht existiert wird null zurückgegeben
   *
   * @param string $viewType
   *   Type der View festpinnen
   *
   * @param string $throwError
   *   Eine Exception werfen wenn die View nicht existiert
   *
   * @return LibTemplate
   *  gibt ein Objekt der Template Klasse zurück,
   *  oder null wenn die Klasse, oder die angefragte Methode, nicht existieren
   *
   */
  public function getSubView
  (
    $key,
    $class,
    $displayMethod = null,
    $viewType = null,
    $throwError = true
  )
  {

    $tplEngine  = $this->getTplEngine();
    $request    = $this->getRequest();
    $response   = $this->getResponse();

    if (!$viewType )
      $viewType =  $tplEngine->type;

    try
    {

      // alle views bekommen zumindest den request und die response injiziter
      switch( $viewType )
      {
        case View::FRONTEND:
        {
          $view = $tplEngine->loadView( $class.'_Frontend' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        case View::AJAX:
        {
          $view = $tplEngine->loadView( $class.'_Ajax'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );

          return $view;
          break;
        }
        case View::MAINTAB:
        {
          // use maintab view
          $view = $tplEngine->newMaintab( $key, $class );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        case View::HTML:
        {
          $view = $tplEngine->loadView( $class.'_Html' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        case View::JSON:
        {
          $view = $tplEngine->loadView( $class.'_Json'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        case View::MODAL:
        {
          $view = $tplEngine->loadView( $class.'_Modal'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        case View::SERVICE:
        {
          $view = $tplEngine->loadView( $class.'_Service'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );

          return $view;
          break;
        }
        case View::AREA:
        {
          $view = $tplEngine->getMainArea( $key, $class.'_Area'  );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );

          return $view;
          break;
        }
        case View::CLI:
        {
          $view = $tplEngine->loadView( $class.'_Cli' );

          if( $displayMethod && !method_exists ( $view, $displayMethod ) )
            return $this->handleNonexistingView( $throwError, $displayMethod );

          $view->setRequest( $request );
          $view->setResponse( $this->response );
          return $view;
          break;
        }
        default:
        {
          return $this->handleNonexistingView( $throwError );
        }
      }

    }
    catch( LibTemplate_Exception $e )
    {
      ///TODO besseres error handling implementieren
      return $this->handleNonexistingView( $throwError );
    }

  }//end public function getSubView */

  /**
   * @lang de:
   *
   *   getSubView ist eine Adapter Methode welche versucht automatisch
   *   das passende ViewObjekt, basierende auf der Anfrage, zu erstellen
   *
   * @see <a href="http://127.0.0.1/wbf/doc/de/index.php?page=architecture.gateway.interfaces" >Doku WebFrap Gateway Interfaces</a>
   *
   * @example
   * <code>
   *  $view = $this->loadView( 'exampleEditForm', 'ExampleDomain' );
   *
   *  if (!$view )
   *  {
   *    $this->invalidAccess
   *    (
   *      $response->i18n->l
   *      (
   *        'The requested View not exists',
   *        'wbfsys.error'
   *      );
   *    );
   *    return false;
   *  }
   * </code>
   *
   * @param string $key schlüssel zum adressieren des view objektes,
   *  wird teils auch in client verwendet
   *
   * @param string $class
   *  der domainspezifische name der view klasse
   *
   * @param string $displayMethod
   *  Die display Methode, welche auf der View erwartet wird,
   *  Wenn die Methode nicht existiert wird null zurückgegeben
   *
   * @param string $viewType
   *   Type der View festpinnen
   *
   * @param string $throwError
   *   Eine Exception werfen wenn die View nicht existiert
   *
   * @return LibTemplate
   *  gibt ein Objekt der Template Klasse zurück,
   *  oder null wenn die Klasse, oder die angefragte Methode, nicht existieren
   *
   */
  public function loadView
  (
    $key,
    $class,
    $displayMethod = null,
    $viewType = null,
    $throwError = true
  )
  {

    return $this->getSubView
    (
      $key,
      $class,
      $displayMethod,
      $viewType,
      $throwError
    );

  }//end public function loadView */

  /**
   * @param boolean $throwError
   * @throws InvalidRequest_Exception
   */
  protected function handleNonexistingView( $throwError, $displayMethod = null )
  {

    if( $throwError )
    {

      $response = $this->getResponse();

      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist

      if( $displayMethod )
      {
        throw new InvalidRequest_Exception
        (
          $response->i18n->l
          (
            'The requested View exists, but does not support method '.$displayMethod.'!',
            'wbf.message'
          ),
          Response::NOT_IMPLEMENTED
        );
      }
      else
      {
        throw new InvalidRequest_Exception
        (
          $response->i18n->l
          (
            'The requested View is not implemented for this action!',
            'wbf.message'
          ),
          'The requested View is not implemented for action: '.$displayMethod,
          Response::NOT_IMPLEMENTED
        );
      }

    }

    return null;

  }//end protected function handleNonexistingView */

  /**
   *
   */
  public function login()
  {

    $request = $this->getRequest();
    $orm     = $this->getOrm();

    ///TODO was sollte der check auf post?
    if (!$request->method( Request::POST ) )
      return false;

    $auth     = new LibAuth( $this, 'Httppost' );
    $response = $this->getResponse();

    if( $auth->login() )
    {

      $user = $this->getUser();
      $user->setDb( $this->getDb() );

      $userName = $auth->getUsername();

      try
      {
        if (!$authRole = $orm->get( 'WbfsysRoleUser', "UPPER(name) = UPPER('{$userName}')" ) )
        {
          $response->addError( 'User '.$userName.' not exists' );
          return false;
        }
      }
      catch( LibDb_Exception $exc )
      {
        $response->addError( 'Error in the query to fetch the data for user: '.$userName );
        return false;
      }

      if
      (
        defined( 'WBF_AUTH_TYPE' )
          && 2 == WBF_AUTH_TYPE && ( $userName != 'admin' )
          && !$authRole->non_cert_login
      )
      {
        $response->addError
        (
          'Login Via Password is not permitted, you need a valid X509 SSO Certificate'
        );
        return false;
      }

      if( $user->login( $authRole ) )
      {
        return true;
      }
      else
      {
        $response->addError( 'Failed to autologin User: '.$auth->getUsername() );
        return false;
      }

    }
    else
    {
      return false;
    }

  }//end public function login */


  /**
   * get the form flags for this management
   * de:
   * {
   *   prüfen ob die standard steuer flags vorhanden sind
   * }
   * @param LibRequestHttp $request
   * @return TFlag
   */
  protected function getFlags( $request )
  {

    return new ContextDefault( $request );

  }//end protected function getFlags */

/*//////////////////////////////////////////////////////////////////////////////
// deprecated methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * request the default action of the ControllerClass
   * @return Ui
   * @deprecated dont use, use the UIloader from the views instead
   */
  public function loadUi( $uiName , $key = null )
  {

    if(!$key)
      $key = $uiName;

    $className = $uiName.'_Ui';
    $oldClassName = 'Ui'.$uiName;


    if (!isset( $this->uis[$key]  ) )
    {
      if(Webfrap::classLoadable($className))
      {
        $this->uis[$key] = new $className();
      }
      else if(Webfrap::classLoadable($oldClassName))
      {
        $this->uis[$key] = new $oldClassName();
      }
      else
      {
        throw new Controller_Exception('Internal Error','Failed to load ui: '.$uiName);
      }
    }

    return $this->uis[$key];

  }//end public function loadUi */


  /**
   * Enter description here...
   *
   * @param string $message the error message
   * @param string $view
   * @deprecated use Controller::errorPage instead
   */
  protected function accessDenied( $message = null , $view = null )
  {

    if (!$message )
    {
      $message =  $this->tplEngine->i18n->l
      (
        'Access denied, please contact your administrator',
        'wbf.message'
      );
    }

    if( DEBUG )
    {
      $caller = Debug::getCaller();
      Debug::console( 'Access Denied from '.$caller );
    }

    Message::addError($message);
    $this->errorPage
    (
      'Access Denied' ,
      $message,
      $view
    );

  }//end protected function accessDenied */

  /**
   * Enter description here...
   *
   * @param string $message the error message
   * @param string $view
   * @deprecated use Controller::errorPage instead
   */
  protected function invalidRequest( $message = null , $view = null )
  {

    if (!$message )
    {
      $message =  $this->tplEngine->i18n->l
      (
        'This Request was invalid. If you think this is a bug call your Administrator',
        'wbf.message'
      );
    }

    if( DEBUG )
    {
      $caller = Debug::getCaller();
      Debug::console( 'This Request was invalid for '.$caller );
    }

    Message::addError($message);
    $this->errorPage
    (
      'Invalid Request' ,
      $message,
      $view
    );

  }//end protected function invalidRequest */

  /**
   * Enter description here...
   *
   * @param string $message the error message
   * @param string $view
   * @deprecated use Controller::errorPage instead
   */
  protected function internalError( $message = null , $view = null )
  {

    if (!$message )
    {
      $message =  $this->tplEngine->i18n->l
      (
        'This Request was invalid. If you think this is a bug call your Administrator',
        'wbf.message'
      );
    }

    if( DEBUG )
    {
      $caller = Debug::getCaller();
      Debug::console( 'This Request was invalid for '.$caller );
    }

    Message::addError($message);
    $this->errorPage
    (
      'Invalid Request' ,
      $message,
      $view
    );

  }//end protected function internalError */

} // end abstract class Controller

