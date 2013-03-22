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
 * @subpackage Mvc
 */
abstract class MvcModule extends BaseChild
{

  /**
   * @var Module
   */
  public static $instance           = null;

  /**
   * the activ mex extension
   * @var Controller
   */
  protected $controller             = null;

  /**
   * name of the activ extension
   * @var string
   */
  protected $controllerName         = null;

  /**
   * The default  extension to load if theres no other Parameter
   * @var string
   */
  protected $defaultControllerName  = 'Base';

  /**
   * the modul name as string
   * @var string
   */
  protected $modName                = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   * @param Base $env
   */
  public function __construct($env = null)
  {

    if (!$env) {
      $env = Webfrap::getActive();
    }

    $this->env = $env;

    $this->modName =  substr(get_class($this), 0 , -7);

  } // end public function __construct  */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return Controller
   */
  public function getActivController()
  {
    return $this->controller;
  }//end public function getActivController */

  /**
   * the main controller, should be overwrited
   * @return void
   */
  public function main()
  {
    $this->runController();
  }//end public function main */

  /**
   * Init Methode for the Controller
   *
   * @return void
   */
  public function init($data = array())
  {

    foreach($data as $name => $value)
      $this->$name = $value;

    // Main fungiert hier gleichzeitig noch als pseudo Wakeup Funktion
    //$acl = $this->getAcl();
    //$acl->loadLists($this->modName);

    $this->getView();
    $this->getUser();

    self::$instance = $this;

    try {
      $this->setController();

      return true;
    } catch (Security_Exception $exc) {
      $this->modulErrorPage
      (
        $exc->getMessage(),
        $exc->getMessage()
      );

      return false;
    }

  }// end public function init */

  /**
   * create a new controller object by a given name
   *
   * @return void
   */
  protected function setController($name = null)
  {

    $request    = $this->getRequest();
    $response   = $this->getResponse();

    if (!$name  )
      $name = $request->param('mex', Validator::CNAME);

    if (DEBUG)
      Debug::console('Controller name '.$name.' Modname ' .$this->modName);

    if (!$name)
      $name = $this->defaultControllerName;

    $classname    = $this->modName.ucfirst($name).WBF_CONTROLLER_PREFIX.'_Controller';
    $classnameOld = 'Controller'.$this->modName.ucfirst($name);

    ///TODO den default model kram muss ich hier mal kicken
    /// der ist nur noch wegen kompatibilitäts problemen drin
    if (WebFrap::loadable($classname)) {
      $this->controller = new $classname($this);
      $this->controller->setDefaultModel($this->modName.ucfirst($name));
      $this->controllerName = $classname;
    } else  if (WebFrap::loadable($classnameOld)) {
      $classname = $classnameOld;
      $this->controller = new $classname($this);
      $this->controller->setDefaultModel($this->modName.ucfirst($name));
      $this->controllerName = $classname;
    } else {

      // Create a Error Page
      $this->modulErrorPage
      (
        'Modul Error',
        $response->i18n->l
        (
          'The requested resource not exists' ,
          'wbf.message'
        )
      );
      //\ Create a Error Page

    }

  } // end protected function setController  */

  /**
   * run the controller
   *
   * @return void
   */
  protected function runController()
  {

    $request   = $this->getRequest();
    $response  = $this->getResponse();

    try {

      if (!$this->initModul())
        throw new Webfrap_Exception('Failed to initialize Modul');

      // no controller? asume init allready reported an error
      if (!$this->controller)
        return false;

      // Initialisieren der Extention
      if (!$this->controller->initController())
        throw new Webfrap_Exception('Failed to initialize Controller');

      // Run the mainpart
      $this->controller->run($request->param('do', Validator::CNAME));

      // shout down the extension
      $this->controller->shutdownController();
      $this->shutdownModul();

    } catch (Exception $exc) {

      Error::report
      (
        $response->i18n->l
        (
          'Module Error: '.$exc->getMessage(),
          'wbf.message' ,
          array($exc->getMessage())
        ),
        $exc
      );

      $type = get_class($exc);

      if (Log::$levelDebug) {
        // Create a Error Page
        $this->modulErrorPage
        (
          $exc->getMessage(),
          '<pre>'.Debug::dumpToString($exc).'</pre>'
        );

      } else {
        switch ($type) {
          case 'Security_Exception':
          {
            $this->modulErrorPage
            (
              $response->i18n->l('Access Denied', 'wbf.message'  ),
              $response->i18n->l( 'Access Denied', 'wbf.message'  )
            );
            break;
          }
          default:
          {

            if (Log::$levelDebug) {
              $this->modulErrorPage
              (
                'Exception '.$type.' not catched ',
                Debug::dumpToString($exc)
              );
            } else {
              $this->modulErrorPage
              (
                $response->i18n->l( 'Sorry Internal Error', 'wbf.message'  ),
                $response->i18n->l( 'Sorry Internal Error', 'wbf.message'  )
              );
            }

            break;
          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch(Exception $exc)

  } // end protected function runController */

  /**
   *
   * @return boolean
   */
  protected function initModul()
  {
    return true;
  }//end protected function initModul */

  /**
   *
   */
  protected function shutdownModul()
  {

  }//end protected function shutdownModul */

  /**
   * @param string $errorTitle
   * @param string $errorMessage
   */
  protected function modulErrorPage($errorTitle , $errorMessage)
  {

    $response = $this->getResponse();
    $view     = $this->getView();

    $response->addError($errorTitle);

    $view->setTemplate('error/message');
    $view->addVar
    (
      array
      (
        'errorMessage' => $errorMessage,
        'errorTitle'   => $errorTitle,
      )
    );

  }//end protected function modulErrorPage */

} // end abstract class Module

