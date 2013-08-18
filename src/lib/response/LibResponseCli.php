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
 * @subpackage tech_core
 */
class LibResponseCli extends LibResponse
{

  /**
   * @var string
   */
  public $type = 'cli';

  /**
   * @var string
   */
  public $status = null;

  /**
   * write
   * @param string $content
   */
  public function write($content)
  {
    fputs(STDOUT, $content);
  }//end public function write */

  /**
   * @param string $content
   */
  public function writeLn($content)
  {
    fputs(STDOUT, $content.NL);
  }//end public function writeLn */

  /**
   * @param string $content
   */
  public function writeErr($content)
  {
    fputs(STDERR, $content);
  }//end public function writeErr */

  /**
   * @param string $content
   */
  public function writeErrLn($content)
  {
    fputs(STDERR, $content.NL);
  }//end public function writeErr */

  /**
   * write
   * @param string $content
   */
  public function console($content)
  {
    fputs(STDOUT, $content.NL);
  }//end public function console */

  /**
   * write
   * @param string $content
   */
  public function line()
  {
    $this->writeLn('--------------------------------------------------------------------------------');
  }//end public function write */

/*//////////////////////////////////////////////////////////////////////////////
// messages
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @console
   * @param string $message
   */
  public function addMessage($message)
  {
    $this->writeLn($message);
  }//end public function addMessage */

  /**
   *
   * @console
   * @param string $warning
   */
  public function addWarning($warning)
  {
    $this->writeLn($warning);
  }//end public function addWarning */

  /**
   *
   * @console
   * @param string $error
   *
   */
  public function addError($error)
  {
    $this->writeErrLn($error);
  }//end public function addError */

  /**
   *
   * Enter description here ...
   * @param int $status
   */
  public function setStatus($status)
  {
    $this->status =  $status;
  }//end public function setStatus */

  /**
   * flush the page
   *
   * @return void
   */
  public function compile()
  {

    $this->tpl->compile();

  }//end public function compile */

  /**
   * flush the page
   *
   * @return void
   */
  public function publish()
  {

    $this->tpl->publish();

  }//end public function publish */

  /**
   * @lang de:
   *
   *   ist eine Adapter Methode welche versucht automatisch
   *   das passende ViewObjekt, basierende auf der Anfrage, zu erstellen
   *
   * @see <a href="http://127.0.0.1/wbf/doc/de/index.php?page=architecture.gateway.interfaces" >Doku WebFrap Gateway Interfaces</a>
   *
   * @example
   * <code>
   *  $view = $this->loadView('exampleEditForm', 'ExampleDomain');
   *
   *  if (!$view)
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

    /* @var $tplEngine LibTemplate   */
    $tplEngine = $this->getTplEngine();
    $request = $this->getRequest();

    if (!$viewType)
      $viewType =  $tplEngine->type;

    try {

      // alle views bekommen zumindest den request und die response injiziter
      switch ($viewType) {
        case View::FRONTEND:
        {
          $view = $tplEngine->loadView($class.'_Frontend');

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Frontend');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::AJAX:
        {
          $view = $tplEngine->loadView($class.'_Ajax'  );

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Ajax');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::MAINTAB:
        {
          // use maintab view
          $view = $tplEngine->newMaintab($key, $class);

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class);

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::HTML:
        {
          $view = $tplEngine->loadView($class.'_Html');

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Html');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::JSON:
        {
          $view = $tplEngine->loadView($class.'_Json'  );

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Json');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::MODAL:
        {
          $view = $tplEngine->loadView($class.'_Modal'  );

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Modal');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::SERVICE:
        {
          $view = $tplEngine->loadView($class.'_Service'  );

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Service');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::AREA:
        {
          $view = $tplEngine->getMainArea($key, $class.'_Area'  );

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Area');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::CLI:
        {
          $view = $tplEngine->loadView($class.'_Cli');

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Cli');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        case View::DOCUMENT:
        {
          $view = $tplEngine->loadView($class.'_Document');

          if ($displayMethod && !method_exists ($view, $displayMethod))
            return $this->handleNonexistingView($throwError, $displayMethod, $viewType.':: '.$class.'_Document');

          $view->setRequest($request);
          $view->setResponse($this);

          return $view;
          break;
        }
        default:
        {
          return $this->handleNonexistingView($throwError, $displayMethod, $viewType);
        }
      }

    } catch (LibTemplate_Exception $e) {
      ///TODO besseres error handling implementieren
      $this->addError('Error '.$e->getMessage());

      return $this->handleNonexistingView($throwError, $displayMethod, $viewType);
    }

  }//end public function loadView */

  /**
   * @param boolean $throwError
   * @param string $displayMethod
   * @param string $viewName
   * @throws InvalidRequest_Exception
   */
  protected function handleNonexistingView($throwError, $displayMethod = null, $viewName = null)
  {

    Debug::dumpFile('missing view '.$viewName, $viewName);

    if ($throwError) {

      $response = $this->getResponse();

      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist

      if ($displayMethod) {
        throw new InvalidRequest_Exception
        (
          'The requested Outputformat '.$viewName.' is not implemented for action: '.$displayMethod.'!',
          Response::NOT_IMPLEMENTED
        );
      } else {
        throw new InvalidRequest_Exception
        (
          'The requested Outputformat '.$viewName.' is not implemented for this action! '.Debug::backtrace(),
          Response::NOT_IMPLEMENTED
        );
      }

    }

    return null;

  }//end protected function handleNonexistingView */

} // end LibResponseCli

