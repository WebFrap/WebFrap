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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Report_Module extends Module
{

  /**
   * create a new controller object by a given name
   *
   * @return void
   */
  protected function setController($name = null )
  {

    $request  = $this->getRequest();
    $response = $this->getResponse();

    if (!$name  )
      $name = $request->param('mex', Validator::CNAME );

    if ( Log::$levelDebug )
      Debug::console( 'Desktop '.$name.' in Module ' .$this->modName );

    if (!$name )
      $name = $this->defaultControllerName;

    $classname = 'Desktop'.$this->modName.ucfirst($name);

    if ( WebFrap::loadable($classname) ) {
      $this->controller = new $classname( );
    } else {

      // Create a Error Page
      $this->modulErrorPage
      (
        'Modul Error',
        $response->i18n->l
        (
          'The requested resource not exists' ,
          'webfrap.tpl'
        )
      );
      //\ Create a Error Page

      Error::report
      (
        'Tried to load a non existing desktop: '.$classname
      );
    }

  } // end protected function setController  */

  /**
   * run the controller
   *
   * @return void
   */
  protected function runController( )
  {

    $request = $this->getRequest();

    try {
      // no controller? asume init allready reported an error
      if (!$this->controller)
        return false;

      // Run the mainpart
      $method = 'run'.ucfirst($request->param('do', Validator::CNAME));

      if (!method_exists($this->controller, $method) ) {
        $this->modulErrorPage
        (
          'Invalid Access',
          'Tried to access a nonexisting service'
        );

        return;
      }

      // Initialisieren der Extention
      if (!$this->controller->initDesktop( ))
        throw new Webfrap_Exception( 'Failed to initialize Controller' );

      $this->controller->$method( );

      // shout down the extension
      $this->controller->shutdownDesktop( );

    } catch ( Exception $exc ) {

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
              I18n::s('wbf.error.ModulActionDeniedTitle'),
              I18n::s('wbf.error.ModulActionDenied')
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
                I18n::s('Sorry Internal Error','wbf.error.ModulCaughtErrorTitle'),
                I18n::s('An Internal Error Occured','wbf.error.ModulCaughtError')
              );
            }

            break;
          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch( Exception $exc )

  } // end protected function runController */

}// end class Report_Module

