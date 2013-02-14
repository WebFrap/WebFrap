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
if (!defined( 'WBF_CONTROLLER_PREFIX' ) )
  define( 'WBF_CONTROLLER_PREFIX', '' );

/**
 *
 * @author Dominik Alexander Bonsch <db@s-db.de>
 * @package WebFrap
 * @subpackage mvc
 */
class LibFlowCli extends LibFlow
{
/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/



 /**
  *
  * @return void
  */
  public function init(  )
  {

    $request = $this->getRequest();
    $this->getUser();
    $this->getTplEngine();

    //make shure the system has language information
    if ($lang = $request->param('lang', Validator::CNAME))
    {
      Conf::setStatus('lang',$lang);
      I18n::changeLang($lang  );
    }

    if ($command = $request->param('c', Validator::TEXT))
    {
      $tmp = explode('.',$command);
      
      if (count($tmp) != 3 )
      {
        $this->getMessage()->addWarning( "Got invalid command ".$command );
        return;
      }
      
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
  * the main method
  * @return void
  */
  public function main($httpRequest = null, $session = null, $transaction = null )
  {

    // Startseiten Eintrag ins Navmenu
    $view         = $this->getTplEngine();
    $httpRequest  = $this->getRequest();
    $user         = $this->getUser();
    $conf         = $this->getConf();

    if (!$classModule = $httpRequest->param(Request::MOD, Validator::CNAME) )
    {
      $view->writeLn('No Command was given');
      $view->printHelp();
      return;
    }

    $modName      = ucfirst($classModule);
    $className    = $modName.'_Module';

    $classNameOld = 'Module'.$modName;

    if ( Webfrap::classLoadable($className) )
    {
      $this->module = new $className();
      $this->module->init();
      $this->module->main();

      // everythin fine
      return true;
    } else {
      $this->runController
      (
        $modName,
        ucfirst($httpRequest->param( Request::CON , Validator::CNAME ))
      );
    }

    return false;

  } // end public function main */

  /**
   * @param Module $module
   * @param Controller $controller
   */
  public function runController($module , $controller  )
  {

    $request = $this->getRequest();

    try
    {

      $classname    = $module.$controller.'_Controller';

      if ( WebFrap::loadable($classname) )
      {

        $this->controller = new $classname( );
        $this->controller->setDefaultModel($module.$controller );
        $this->controllerName = $classname;

        $action = $request->param(Request::RUN, Validator::CNAME );

        // Initialisieren der Extention
        if (!$this->controller->initController( ))
          throw new WebfrapSys_Exception( 'Failed to initialize Controller' );

        // Run the mainpart
        $this->controller->run($action );

        // shout down the extension
        $this->controller->shutdownController( );

      } else {
        throw new WebfrapUser_Exception( 'Resource '.$classname.' not exists!' );
      }

    }
    catch( Exception $exc )
    {

      Error::report
      (
        I18n::s
        (
          'Module Error: '.$exc->getMessage(),
          'wbf.error.caughtModulError' ,
          array($exc->getMessage())
        ),
        $exc
      );

      // if the controller ist not loadable set an error controller
      $this->controller     = new Error_Controller();
      $this->controllerName = 'Error_Controller';
      //\Reset The Extention

      if ( Log::$levelDebug )
      {
        $this->controller->displayError( 'displayException' , array($exc ) );
      } else {
        $this->controller->displayError( 'displayEnduserError' , array($exc ) );
      }//end else

    }//end

  }//end public function runController



  /**
   *
   */
  public function shutdown()
  {

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
  public function panikShutdown($file, $line, $lastMessage )
  {

    Log::fatal
    (
      'System got killed: '.$file.' Linie: '.$line .' reason: '.$lastMessage
    );

    echo 'Fatal Error, System died :-(('.NL;

    echo $lastMessage.NL;
    exit();

  } // end public function panikShutdown */


} // end of ControllerCli

