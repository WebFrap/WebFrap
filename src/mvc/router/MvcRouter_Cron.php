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

// Sicher stellen, dass nur Cms Controller aufgerufen werden können
if (!defined('WBF_CONTROLLER_PREFIX'))
  define('WBF_CONTROLLER_PREFIX', '');

/**
 * @lang de:
 *
 * Der Supercontroller der alle anderen Controller verwaltet, den Status den
 * Kompletten Systems speichert und die Benutzereingaben verarbeite.
 * Weiter liest der Supercontroller bei Systemstart die Systemkonfiguration aus.
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage Mvc
 */
class MvcRouter_Cron extends Base
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the active module object
   * @var Module
   */
  protected $module               = null;

  /**
   * name of the active module
   * @var string
   */
  protected $moduleName           = null;

  /**
   * the activ controller object
   * @var Controller
   */
  protected $controller           = null;

  /**
   * name of the activ controller
   * @var string
   */
  protected $controllerName       = null;

  /**
   * mappertabelle für shortlinks
   *
   * @var array
   */
  protected $redirectMap          = array();

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * check for hidden redirects in the url
   * @return void
   */
  protected function checkRedirect()
  {

    $conf = $this->getConf();

    foreach ($conf->redirect as $name => $data) {
      if (isset($_GET[$name])) {
        $_GET['c']      = $data[0];
        $_GET[$data[1]] = $_GET[$name];
        break;
      }
    }

  }//end protected function checkRedirect */

 /**
  *
  * @return void
  */
  public function init()
  {

    $request = $this->getRequest();
    $this->getResponse();
    $this->getSession();
    $this->getUser();
    $this->getTplEngine();

    //make shure the system has language information
    if ($lang = $request->param('lang', Validator::CNAME)) {
      Conf::setStatus('lang',$lang);
      I18n::changeLang($lang  );
    }

    if (defined('MODE_MAINTENANCE')) {
      $map = array
      (
        Request::MOD  => 'Maintenance',
        Request::CON  => 'Base',
        Request::RUN  => 'message'
      );
      $request->addParam($map);

      return;
    }

    $this->checkRedirect();

    if ($command = $request->param('c', Validator::TEXT)) {
      $tmp = explode('.',$command);
      $map = array
      (
        Request::MOD  => $tmp[0],
        Request::CON  => $tmp[1],
        Request::RUN  => $tmp[2]
      );
      $request->addParam($map);
    } elseif ($command = $request->data('c', Validator::TEXT)) {
      $tmp = explode('.',$command);
      $map = array
      (
        Request::MOD  => $tmp[0],
        Request::CON  => $tmp[1],
        Request::RUN  => $tmp[2]
      );
      $request->addParam($map);
    }

  }//end  public function init */

 /**
  *
  * @return void
  */
  public function wakeup()
  {

    $request = $this->getRequest();
    $session = $this->getSession();
    $this->getUser();
    $this->getTplEngine();

    //make shure the system has language information
    if ($lang = $request->param('lang', Validator::CNAME  )) {
      $session->setStatus('activ.lang' , $lang);
      I18n::changeLang($session->getStatus['activ.lang']);
    }

    if (defined('MODE_MAINTENANCE')) {
      $map = array
      (
        Request::MOD  => 'Maintenance',
        Request::CON  => 'Base',
        Request::RUN  => 'message'
      );
      $request->addParam($map);

      return;
    }

    $this->checkRedirect();

    if ($command = $request->param('c', Validator::TEXT  )) {
      $tmp = explode('.',$command);
      $map = array
      (
        Request::MOD  => $tmp[0],
        Request::CON  => $tmp[1],
        Request::RUN  => $tmp[2]
      );
      $request->addParam($map);
    } elseif ($command = $request->data('c', Validator::TEXT)) {
      $tmp = explode('.',$command);
      $map = array
      (
        Request::MOD  => $tmp[0],
        Request::CON  => $tmp[1],
        Request::RUN  => $tmp[2]
      );
      $request->addParam($map);
    }

    Debug::console('$_GET' , $_GET);

  }//end  public function wakeup */

  /**
  * the main method
  * @param LibRequestPhp $httpRequest
  * @param LibSessionPhp $session
  * @param Transaction $transaction
  * @return void
  */
  public function main(  )
  {

    // Startseiten Eintrag ins Navmenu
    $view     = $this->getView();

    $session      = $this->session;
    $httpRequest  = $this->request;
    $transaction  = $this->transaction;

    $user = $this->getUser();
    Debug::console('USER' , $user);

    if (!$sysClass = $httpRequest->param(Request::MOD, Validator::CNAME)) {

      if (!$user->getLogedIn()) {
        $tmp = explode('.',$session->getStatus('tripple.annon'));
        $map = array
        (
          Request::MOD  => $tmp[0],
          Request::CON  => $tmp[1],
          Request::RUN  => $tmp[2]
        );
        $httpRequest->addParam($map);

        $sysClass = $tmp[0];
      } else {
        $tmp = explode('.',$session->getStatus('tripple.user'));
        $map = array
        (
          Request::MOD  => $tmp[0],
          Request::CON  => $tmp[1],
          Request::RUN  => $tmp[2]
        );
        $httpRequest->addParam($map);

        $sysClass = $tmp[0];
      }
    }//end if (!$sysClass = $httpRequest->param(Request::MOD,'Cname'))

    $modName      = ucfirst($sysClass);
    $className    = $modName.'_Module';

    $classNameOld = 'Module'.$modName;

    if (Webfrap::classExists($className)) {
      Debug::console('$module',$className);

      $this->module = new $className($this);
      $this->module->init();
      $this->module->main();

      // everythin fine
      return true;
    } else  if (Webfrap::classExists($classNameOld)) {
      Debug::console('$module',$classNameOld);

      $this->module = new $classNameOld($this);
      $this->module->init();
      $this->module->main();

      // everythin fine
      return true;
    } else {
      $this->runController
      (
        $modName,
        ucfirst($httpRequest->param(Request::CON , Validator::CNAME))
      );
    }

    return false;

  } // end public function main */

  /**
   *
   * @param Module $module
   * @param Controller $controller
   */
  public function runController($module , $controller  )
  {

    $request = $this->getRequest();

    try {

      $classname    = $module.$controller.WBF_CONTROLLER_PREFIX.'_Controller';
      $classnameOld = 'Controller'.$module.$controller;

      if (WebFrap::classExists($classname)) {
        $this->controller = new $classname($this);
        $this->controller->setDefaultModel($module.$controller);
        $this->controllerName = $classname;

        $action = $request->param(Request::RUN, Validator::CNAME);

        // Initialisieren der Extention
        if (!$this->controller->initController())
          throw new WebfrapSys_Exception('Failed to initialize Controller');

        // Run the mainpart
        $this->controller->run($action  );

        // shout down the extension
        $this->controller->shutdownController();

      } elseif (WebFrap::classExists($classnameOld)) {

        $classname = $classnameOld;

        $this->controller = new $classnameOld($this);
        $this->controller->setDefaultModel($module.$controller);
        $this->controllerName = $classnameOld;

        $action = $request->param(Request::RUN, Validator::CNAME);

        // Initialisieren der Extention
        if (!$this->controller->initController())
          throw new WebfrapSys_Exception('Failed to initialize Controller');

        // Run the mainpart
        $this->controller->run($action  );

        // shout down the extension
        $this->controller->shutdownController();

      } else {
        throw new WebfrapUser_Exception('Resource '.$classname.' not exists!');
      }

    } catch (Exception $exc) {

      Error::report
      (
        I18n::s
        (
          'Module Error: {@message@}',
          'wbf.message' ,
          array('message' => $exc->getMessage())
        ),
        $exc
      );

      // if the controller ist not loadable set an error controller
      $this->controller     = new Error_Controller($this);
      $this->controllerName = 'ControllerError';
      //\Reset The Extention

      if (Log::$levelDebug) {
        $this->controller->displayError('displayException' , array($exc));
      } else {
        $this->controller->displayError('displayEnduserError' , array($exc));
      }//end else

    }//end catch(Exception $exc)

  }//end public function runController */

  /**
   *
   */
  public function out()
  {

    if (View::$published)
      throw new Webfrap_Exception("Allready published!!");

    View::$published = true;

    $tplEngine = $this->getTplEngine();
    $tplEngine->compile();

    if (BUFFER_OUTPUT) {
      $errors = ob_get_contents();

      ob_end_clean();
      $tplEngine->publish(); //tell the view to publish the data
      ob_start();

      return $errors;
    }

    $tplEngine->publish(); //tell the view to publish the data

    return null;

  }//end public function out */

  /**
   * @param string $errorKey
   * @param string $data
   */
  public function httpError($errorKey , $data = null)
  {

    $tplEngine = $this->getView();

    $errorClass = 'LibHttpError'.$errorKey;

    if (!Webfrap::classExists($errorClass))
      $errorClass = 'LibHttpError500';

    $error = new $errorClass($data);
    $error->publish($tplEngine);

    $tplEngine->compile();

    if (BUFFER_OUTPUT) {
      $errors = ob_get_contents();

      ob_end_clean();
      $tplEngine->publish(); //tell the view to publish the data
      ob_start();

      return $errors;
    }

    $tplEngine->publish(); //tell the view to publish the data

  }//end public function out */

  /**
   * Sauberes beenden des Requests
   */
  public function shutdown()
  {

    if (Log::$levelDebug)
      Debug::publishDebugdata();

    if (Session::$session->getStatus('logout')) {
      Log::info
      (
        'User logged of from system'
      );

      Session::destroy();
    }

    Session::close();
    Db::shutdown();
    Webfrap::saveClassIndex();
    I18n::writeCache();

  }//end public function shutdown */

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @param string $file
  * @param int $line
  * @param string $lastMessage
  * @return array
  */
  public function panikShutdown($file, $line,  $lastMessage)
  {

    Log::fatal
    (
      'System got killed: '.$file.' Linie: '.$line .' reason: '.$lastMessage
    );

    $messages = ob_get_contents();
      ob_end_clean();

    echo '<h1>Fatal Error, System died :-((</h1>';

    if (Log::$levelDebug)
      echo $messages;

    echo '<p>'.$lastMessage.'</p>';
    session_destroy();
    exit();

  } // end public function panikShutdown */

/*//////////////////////////////////////////////////////////////////////////////
// System Status
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * methode for an intern redirect throw chaching the states an recall the main
   * function
   *
   * @var array[optional]
   * @return void
   */
  public function redirect($stati  )
  {

    $request = $this->getRequest();

    $request->addParam($stati);
    $this->main();

  }//end public function redirect */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectToDefault()
  {

    $conf = $this->getConf();
    $user = $this->getUser();

    if ($user->getLogedin()  ) {

      $profile = $user->getProfileName();

      if ($status = $conf->getStatus('default.action.profile_'.$profile)  ) {
        $tmp = explode('.',$status);
      } elseif ($status = $conf->getStatus('tripple.user')) {
        $status = $conf->getStatus('tripple.user');
        $tmp = explode('.',$status);
      } else {
        $status = 'webfrap.netsktop.display';
        $tmp = explode('.',$status);
      }

    } else {
      if ($status = $conf->getStatus('tripple.annon')) {
        $tmp = explode('.', $conf->getStatus('tripple.annon'));
      } else {
        $status = 'Webfrap.Auth.form';
        $tmp = explode('.',$status);
      }

    }

    if (3 != count($tmp)) {
      Debug::console('tried to forward to an invalid status '.$status);

      return;
    }

    $map = array
    (
      Request::MOD  => $tmp[0],
      Request::CON  => $tmp[1],
      Request::RUN  => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectToDefault */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByKey($key , $forceLogedin = true)
  {

    if (!$forceLogedin || $this->user->getLogedin()  )
      $tmp = explode('.',$this->session->getStatus($key));
    else
      $tmp = explode('.',$this->session->getStatus('tripple.login'));

    $map = array
    (
      Request::MOD  => $tmp[0],
      Request::CON  => $tmp[1],
      Request::RUN  => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectByKey */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByTripple($key , $forceLogedin = true)
  {

    if (!$forceLogedin || $this->user->getLogedin()  )
      $tmp = explode('.',$key);
    else
      $tmp = explode('.',$this->session->getStatus('tripple.login'));

    $map = array
    (
      Request::MOD  => $tmp[0],
      Request::CON  => $tmp[1],
      Request::RUN  => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectByTripple */

  /**
   * method for intern redirect to the loginpage
   * @return void
   */
  public function redirectToLogin()
  {

    $tmp = explode('.', $this->session->getStatus('tripple.login'));
    $map = array
    (
      Request::MOD=> $tmp[0],
      Request::CON => $tmp[1],
      Request::RUN => $tmp[2]
    );
    $this->request->addParam($map);

    if ('ajax' == $this->request->param('rqt', Validator::CNAME)) {
      $tmp = explode('.', $this->session->getStatus('tripple.login'));
      //$this->tplEngine->setStatus(401);
      $this->tpl->redirectUrl = 'index.php?mod='.$tmp[0].'&amp;mex='.$tmp[1].'&amp;do='.$tmp[2];
    }

    $this->main();

  }//end public function redirectToLogin */

  /**
   * @lang de:
   * Das aktuive module objekt anfragen
   *
   * @return Module
   */
  public function getActivMod()
  {
    return $this->module;
  }//end public function getActivMod */

}//end class LibFlowApachemod

