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
class WebfrapCache_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected $defaultAction = 'cleancache';

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $callAble = array
  (
    'cleancache',
    'info'
  );

////////////////////////////////////////////////////////////////////////////////
// The Controller and Init
////////////////////////////////////////////////////////////////////////////////

  /**
   * the logic flow controller method
   * @param string $action the action to do
   */
  public function run( $action = null )
  {


    if(!$this->checkAction( $action ))
    {
      return;
    }

    // Check if the user may be here
    if( ! $this->user->isAdmin()  )
    {
      $sys = Webfrap::getInstance();

      Message::addError(I18n::s
      (
        'Zugriff verweigert',
        'wbf.message.MexAccessDenied',
        array('Cache Management')
      ));

      $sys->redirectToDefault();
      return;
    }

    $this->defaultRun( );

    $this->createMenu( );

  }//end public function run


////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @return void
   */
  public function info()
  {
    $this->cleanCache();
  }//end public function info */

  /**
   *
   * @return void
   */
  public function cleanCache()
  {

    ///FIXME architecture

    $this->view->setTemplate('Plain','base');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      PATH_GW.'cache/entity_cache/',
      PATH_GW.'cache/virtual_entity_cache/'
    );

    foreach( $toClean as $folder )
    {
      if(SFilesystem::cleanFolder($folder))
      {
        Message::addMessage(I18n::s
        (
          'Successfully cleaned cache {@folder@}',
          'wbf.message',
          array('folder' => $folder)
        ));
      }
      else
      {
        Message::addError(I18n::s
        (
          'Failed to cleane cache {@folder@}',
          'wbf.message',
          array( 'folder' => $folder)
        ));
      }
    }

  }//end public function cleanCache */

} // end class ControllerWebfrapCache


