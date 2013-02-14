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
class Wbfpage_Module extends Module
{

  /**
   * the main controller, should be overwrited
   * @return void
   */
  public function main()
  {

    $this->tplEngine->setHtmlHead( 'public' );
    $this->tplEngine->setIndex( 'public/default' );

    $this->runController();

  }//end public function main */


  /**
   * Ausführen des Controllers
   *
   * @return void
   */
  protected function runController( )
  {

    try
    {

      $request = $this->getRequest();

      if (!$this->initModul() )
        throw new WebfrapSys_Exception( 'Failed to initialize Modul' );

      // Initialisieren der Extention
      if (!$this->controller || !$this->controller->initController( ))
        throw new WebfrapSys_Exception( 'Failed to initialize Controller' );

      // Run the mainpart

      $method = 'page'.ucfirst($request->get('do',Validator::CNAME));

      if ( method_exists($this->controller, $method) )
      {
        if (!$this->controller->$method( ))
        {
          $this->controller->errorPage( 'Error 500' , 'something went wrong' );
        }
      } else {
        $this->controller->errorPage( 'Error 404' , 'requested page not exists' );
      }

      // shout down the extension
      $this->controller->shutdownController( );
      $this->shutdownModul();

    }
    catch( Exception $exc )
    {

      if ( DEBUG )
      {
        $this->modulErrorPage
        (
          'Exception: '.get_class($exc).' msg: '.$exc->getMessage().' not catched ',
          Debug::dumpToString($exc)
        );
      } else {
        $this->modulErrorPage
        (
          I18n::s('Sorry Internal Error','wbf.error.ModulCaughtErrorTitle'),
          I18n::s('An Internal Error Occured','wbf.error.ModulCaughtError')
        );
      }

    }//end catch

  } // end protected function runController */


  /**
   * Funktion zum aktivsetzen von extentions
   *
   * @return void
   */
  protected function setController($name = null )
  {

    $request = $this->getRequest();

    if (!$name  )
      $name = $request->get('mex',Validator::CNAME);

     $classname   = ''.ucfirst($name).'_Page';

     if (!WebFrap::loadable($classname))
       $classname = 'Page'.ucfirst($name);

    if (DEBUG)
      Debug::console('Page: '.$classname );

    if ( WebFrap::loadable($classname) )
    {
      $this->controller     = new $classname();
      $this->controllerName = $classname;
      //$this->controllerBase = $name;

      return true;
    } else {
      //Reset The Extention
      $this->controller     = null;
      $this->controllerName = null;
      //\Reset The Extention

      // Create a Error Page
      $this->modulErrorPage
      (
        'Modul Error',
        I18n::s( 'The requested resource not exists' , 'wbf.message' )
      );
      //\ Create a Error Page

      Error::addError
      (
        'Unbekannte Extension angefordert: '.$classname
      );

      return false;
    }

  } // end protected function setController */

}// end class Wbfpage_Module

