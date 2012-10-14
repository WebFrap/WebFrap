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
 * @subpackage ModDeveloper
 */
class DeveloperDebug_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default Action this action will be called there is noch
   * action in the request
   * @var string
   */
  protected $defaultAction = 'message';

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $callAble = array( 'message', 'filedump' );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function message( )
  {

    Controller::addMessage('Called Message');

  }//end public function message( )

  public function fileDump()
  {

    Controller::addMessage('Called Message');
    Debug::console( '$_FILES' , $_FILES );

  }//end public function fileDump()


} // end class MexDeveloperStatus

