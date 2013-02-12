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
 *
 * @todo überarbeiten
 */
class Widget_Module
  extends Module
{

  /**
   * create a new controller object by a given name
   *
   * @return void
   */
  protected function setController( $name = null )
  {

    $name = $this->getRequest()->param( 'mex', Validator::CNAME );

    if( Log::$levelDebug )
      Debug::console( 'Widget: '.$name );

    $className    = ''.SParserString::subToCamelCase($name).'_Widget';
    $classNameOld = 'WgtWidget'.SParserString::subToCamelCase($name);

    if ( !Webfrap::classLoadable($className) ) {
      $className = $classNameOld;

      if ( !Webfrap::classLoadable($className) ) {
        $className = 'Error_Widget';
      }
    }

    $this->controller = new $className();

  } // end protected function setController  */

  /**
   * run the controller
   *
   * @return void
   */
  protected function runController( )
  {

    $view = $this->getTplEngine();

    try {
      // no controller? asume init allready reported an error
      if( !$this->controller )

        return false;

      // Run the mainpart
      $method = 'run'.ucfirst($this->request->param( 'do', Validator::CNAME ) );

      if ( !method_exists( $this->controller, $method ) ) {
        $this->modulErrorPage
        (
          'Invalid Access',
          'Tried to access a nonexisting service on this widget'
        );

        return;
      }

      // Initialisieren der Extention
      if( !$this->controller->init( ) )
        throw new Webfrap_Exception( 'Failed to initialize Widget' );

      $this->controller->$method( );

      // shout down the extension
      $this->controller->shutdown( );

    } catch ( Exception $exc ) {

      Error::report
      (
        I18n::s
        (
          'Module Error: {@message@}',
          'wbf.message' ,
          array('message'=>$exc->getMessage())
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

            $i18n = $view->getI18n();

            $this->modulErrorPage
            (
              $i18n->l('Action denied','wbf.message'),
              $i18n->l('Action denied','wbf.message')
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
              $i18n = $view->getI18n();
              $this->modulErrorPage
              (
                $i18n->l('Sorry Internal Error','wbf.message'),
                $i18n->l('An Internal Error Occured','wbf.message')
              );
            }

            break;
          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch( Exception $exc )

  } // end protected function runController */

}// end class Widget_Module
